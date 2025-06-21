<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BrevoMailService;
use App\Models\User;

class TestBrevoConnection extends Command
{
    protected $signature = 'brevo:test {email?}';
    protected $description = 'Test Brevo SMTP connection and send a test email';

    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('¿A qué email quieres enviar la prueba?');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email inválido');
            return 1;
        }

        $this->info('Probando conexión con Brevo SMTP...');

        try {
            // Probar con Laravel Mail
            \Mail::raw('Este es un email de prueba desde Laravel con Brevo SMTP.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('🧪 Prueba de Conexión - Sistema de Inventario');
            });

            $this->info('✅ Email de prueba enviado exitosamente a: ' . $email);

            // Probar servicio de Brevo
            $brevoService = new BrevoMailService();

            $result = $brevoService->sendTransactionalEmail([
                'to' => [['email' => $email, 'name' => 'Usuario de Prueba']],
                'subject' => '🚀 Prueba de API Brevo - Sistema de Inventario',
                'htmlContent' => '
                    <h2>¡Conexión exitosa con Brevo!</h2>
                    <p>Este email fue enviado usando la API de Brevo directamente.</p>
                    <p><strong>Fecha:</strong> ' . now()->format('d/m/Y H:i:s') . '</p>
                    <p><strong>Sistema:</strong> Laravel + Brevo SMTP</p>
                ',
                'textContent' => 'Conexión exitosa con Brevo! Este email fue enviado usando la API de Brevo.',
                'tags' => ['test', 'inventory-system']
            ]);

            if ($result) {
                $this->info('✅ Email enviado también via API de Brevo');
                $this->info('📧 Message ID: ' . ($result['messageId'] ?? 'N/A'));
            } else {
                $this->warn('⚠️ Hubo un problema con la API de Brevo, pero SMTP funciona');
            }

            // Mostrar configuración actual
            $this->info("\n📋 Configuración actual:");
            $this->line('Host: ' . config('mail.mailers.smtp.host'));
            $this->line('Puerto: ' . config('mail.mailers.smtp.port'));
            $this->line('Encriptación: ' . config('mail.mailers.smtp.encryption'));
            $this->line('Usuario: ' . config('mail.mailers.smtp.username'));
            $this->line('Remitente: ' . config('mail.from.address'));

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error al enviar email: ' . $e->getMessage());

            $this->info("\n🔧 Verifica tu configuración:");
            $this->line('1. MAIL_HOST=smtp-relay.brevo.com');
            $this->line('2. MAIL_PORT=587');
            $this->line('3. MAIL_USERNAME=tu-email@tudominio.com');
            $this->line('4. MAIL_PASSWORD=tu-brevo-smtp-key');
            $this->line('5. MAIL_ENCRYPTION=tls');

            return 1;
        }
    }
}
