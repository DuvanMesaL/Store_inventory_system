<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrevoMailService;
use App\Mail\CustomMailable;
use App\Notifications\WelcomeUser;
use App\Notifications\LowStockAlert;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class EmailTestController extends Controller
{
    protected $brevoService;

    public function __construct(BrevoMailService $brevoService)
    {
        $this->brevoService = $brevoService;
    }

    /**
     * Mostrar página de pruebas de email
     */
    public function index()
    {
        return view('admin.email-test');
    }

    /**
     * Enviar email de prueba básico
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type' => 'required|in:basic,welcome,low_stock,custom'
        ]);

        try {
            switch ($request->type) {
                case 'basic':
                    $this->sendBasicTest($request->email);
                    break;
                case 'welcome':
                    $this->sendWelcomeTest($request->email);
                    break;
                case 'low_stock':
                    $this->sendLowStockTest($request->email);
                    break;
                case 'custom':
                    $this->sendCustomTest($request->email, $request->subject, $request->content);
                    break;
            }

            return back()->with('success', '✅ Email de prueba enviado exitosamente a: ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al enviar email: ' . $e->getMessage());
        }
    }

    private function sendBasicTest($email)
    {
        Mail::raw('Este es un email de prueba básico desde el Sistema de Inventario usando Brevo SMTP.', function ($message) use ($email) {
            $message->to($email)
                    ->subject('🧪 Prueba Básica - Sistema de Inventario');
        });
    }

    private function sendWelcomeTest($email)
    {
        // Crear usuario temporal para la prueba
        $tempUser = (object)[
            'name' => 'Usuario de Prueba',
            'email' => $email,
            'role' => 'employee'
        ];

        // Simular notificación
        Notification::route('mail', $email)->notify(new WelcomeUser());
    }

    private function sendLowStockTest($email)
    {
        // Obtener algunos productos reales o crear datos de prueba
        $products = Product::lowStock()->with('category')->take(3)->get();

        if ($products->isEmpty()) {
            // Crear productos de prueba si no hay productos con stock bajo
            $products = collect([
                (object)[
                    'name' => 'Producto Demo 1',
                    'stock_quantity' => 2,
                    'min_stock_level' => 10,
                    'category' => (object)['name' => 'Categoría Demo']
                ],
                (object)[
                    'name' => 'Producto Demo 2',
                    'stock_quantity' => 0,
                    'min_stock_level' => 5,
                    'category' => (object)['name' => 'Otra Categoría']
                ]
            ]);
        }

        Notification::route('mail', $email)->notify(new LowStockAlert($products));
    }

    private function sendCustomTest($email, $subject, $content)
    {
        Mail::to($email)->send(new CustomMailable(
            $subject ?: 'Email Personalizado - Sistema de Inventario',
            $content ?: 'Este es un email personalizado enviado desde el Sistema de Inventario.',
            route('dashboard'),
            'Ver Dashboard'
        ));
    }

    /**
     * Obtener estadísticas de Brevo
     */
    public function getEmailStats()
    {
        $stats = $this->brevoService->getEmailStatistics(
            now()->subDays(30)->format('Y-m-d'),
            now()->format('Y-m-d')
        );

        return response()->json($stats);
    }

    /**
     * Probar conexión con Brevo API
     */
    public function testBrevoConnection()
    {
        try {
            $result = $this->brevoService->sendTransactionalEmail([
                'to' => [['email' => Auth::user()->email, 'name' => Auth::user()->name]],
                'subject' => '🔧 Prueba de Conexión API Brevo',
                'htmlContent' => '<h2>¡Conexión exitosa!</h2><p>La API de Brevo está funcionando correctamente.</p>',
                'textContent' => 'Conexión exitosa! La API de Brevo está funcionando correctamente.',
                'tags' => ['test', 'api-connection']
            ]);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Conexión exitosa con Brevo API',
                    'messageId' => $result['messageId'] ?? null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en la conexión con Brevo API'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
