<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockAlert;
use App\Services\BrevoMailService;

class CheckLowStock extends Command
{
    protected $signature = 'inventory:check-low-stock {--force : Forzar envío aunque no haya cambios}';
    protected $description = 'Check for products with low stock and send notifications';

    public function handle()
    {
        $this->info('🔍 Verificando productos con stock bajo...');

        $lowStockProducts = Product::lowStock()
            ->with(['category', 'supplier'])
            ->get();

        if ($lowStockProducts->count() > 0) {
            $this->warn("⚠️ Encontrados {$lowStockProducts->count()} productos con stock bajo:");

            // Mostrar productos en consola
            $this->table(
                ['Producto', 'Categoría', 'Stock Actual', 'Stock Mínimo', 'Estado'],
                $lowStockProducts->map(function($product) {
                    $status = $product->stock_quantity == 0 ? '🔴 SIN STOCK' : '🟡 STOCK BAJO';
                    return [
                        $product->name,
                        $product->category->name,
                        $product->stock_quantity,
                        $product->min_stock_level,
                        $status
                    ];
                })
            );

            // Obtener usuarios para notificar
            $users = User::whereIn('role', ['admin', 'manager'])
                        ->where('active', true)
                        ->get();

            if ($users->count() > 0) {
                $this->info("\n📧 Enviando notificaciones a {$users->count()} usuario(s)...");

                $bar = $this->output->createProgressBar($users->count());
                $bar->start();

                $successCount = 0;
                foreach ($users as $user) {
                    try {
                        $user->notify(new LowStockAlert($lowStockProducts));
                        $successCount++;
                        $this->line("\n✅ Notificación enviada a: {$user->email}");
                    } catch (\Exception $e) {
                        $this->line("\n❌ Error enviando a {$user->email}: " . $e->getMessage());
                    }
                    $bar->advance();
                }

                $bar->finish();
                $this->info("\n\n📊 Resumen:");
                $this->info("✅ Notificaciones enviadas exitosamente: {$successCount}");
                $this->info("❌ Errores: " . ($users->count() - $successCount));

                // Registrar estadísticas en Brevo si está configurado
                if (config('mail.brevo.api_key')) {
                    $brevoService = new BrevoMailService();
                    $brevoService->createOrUpdateContact(config('mail.from.address'), [
                        'LAST_LOW_STOCK_CHECK' => now()->toISOString(),
                        'LOW_STOCK_PRODUCTS_COUNT' => $lowStockProducts->count(),
                    ]);
                }

            } else {
                $this->warn('⚠️ No hay usuarios administradores o managers activos para notificar.');
            }

        } else {
            $this->info('✅ ¡Excelente! No hay productos con stock bajo.');

            if ($this->option('force')) {
                $this->info('🔄 Enviando notificación de prueba (--force activado)...');

                // Crear productos de ejemplo para la prueba
                $testProducts = collect([
                    (object)[
                        'name' => 'Producto de Prueba',
                        'stock_quantity' => 2,
                        'min_stock_level' => 5,
                        'category' => (object)['name' => 'Categoría de Prueba']
                    ]
                ]);

                $adminUser = User::where('role', 'admin')->first();
                if ($adminUser) {
                    $adminUser->notify(new LowStockAlert($testProducts));
                    $this->info('📧 Notificación de prueba enviada a: ' . $adminUser->email);
                }
            }
        }

        $this->info("\n🏁 Verificación completada: " . now()->format('d/m/Y H:i:s'));
        return 0;
    }
}
