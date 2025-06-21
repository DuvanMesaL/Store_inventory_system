<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupSystem extends Command
{
    protected $signature = 'system:setup {--fresh : Ejecutar migraciones frescas}';
    protected $description = 'Configurar completamente el sistema de inventario';

    public function handle()
    {
        $this->info('🚀 Configurando Sistema de Inventario...');

        try {
            // Verificar conexión a base de datos
            $this->info('📊 Verificando conexión a base de datos...');
            DB::connection()->getPdo();
            $this->info('✅ Conexión a base de datos exitosa');

            // Ejecutar migraciones
            if ($this->option('fresh')) {
                $this->info('🔄 Ejecutando migraciones frescas...');
                Artisan::call('migrate:fresh', ['--force' => true]);
            } else {
                $this->info('📋 Ejecutando migraciones...');
                Artisan::call('migrate', ['--force' => true]);
            }
            $this->info('✅ Migraciones completadas');

            // Ejecutar seeders
            $this->info('🌱 Poblando base de datos...');
            Artisan::call('db:seed', ['--force' => true]);
            $this->info('✅ Base de datos poblada');

            // Crear enlace simbólico para storage
            $this->info('🔗 Creando enlace simbólico para storage...');
            Artisan::call('storage:link');
            $this->info('✅ Enlace simbólico creado');

            // Limpiar y optimizar
            $this->info('🧹 Limpiando cachés...');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            $this->info('⚡ Optimizando aplicación...');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            $this->info('✅ Sistema configurado exitosamente!');

            $this->line('');
            $this->info('👥 Usuarios creados:');
            $this->line('  • admin@inventario.com (password123) - Administrador');
            $this->line('  • manager@inventario.com (password123) - Manager');
            $this->line('  • empleado@inventario.com (password123) - Empleado');

            $this->line('');
            $this->info('🔧 Próximos pasos:');
            $this->line('  1. Configura tus credenciales de Brevo en el archivo .env');
            $this->line('  2. Ejecuta: php artisan brevo:test tu-email@ejemplo.com');
            $this->line('  3. Inicia el worker de colas: php artisan queue:work');
            $this->line('  4. Inicia el servidor: php artisan serve');

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error durante la configuración: ' . $e->getMessage());
            return 1;
        }
    }
}
