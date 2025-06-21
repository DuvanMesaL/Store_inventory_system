<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.brevo.com/v3';

    public function __construct()
    {
        $this->apiKey = config('mail.brevo.api_key');
    }

    /**
     * Enviar email usando la API de Brevo
     */
    public function sendTransactionalEmail($data)
    {
        try {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/smtp/email', [
                'sender' => [
                    'name' => config('mail.brevo.sender_name'),
                    'email' => config('mail.brevo.sender_email'),
                ],
                'to' => $data['to'],
                'subject' => $data['subject'],
                'htmlContent' => $data['htmlContent'],
                'textContent' => $data['textContent'] ?? null,
                'tags' => $data['tags'] ?? ['inventory-system'],
            ]);

            if ($response->successful()) {
                Log::info('Email enviado exitosamente via Brevo', [
                    'message_id' => $response->json('messageId'),
                    'to' => $data['to'],
                ]);
                return $response->json();
            } else {
                Log::error('Error al enviar email via Brevo', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Excepción al enviar email via Brevo', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            return false;
        }
    }

    /**
     * Obtener estadísticas de emails
     */
    public function getEmailStatistics($startDate = null, $endDate = null)
    {
        try {
            $params = [];
            if ($startDate) $params['startDate'] = $startDate;
            if ($endDate) $params['endDate'] = $endDate;

            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
            ])->get($this->baseUrl . '/smtp/statistics/events', $params);

            return $response->successful() ? $response->json() : false;
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de Brevo', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Crear o actualizar contacto en Brevo
     */
    public function createOrUpdateContact($email, $attributes = [])
    {
        try {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/contacts', [
                'email' => $email,
                'attributes' => $attributes,
                'updateEnabled' => true,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Error al crear/actualizar contacto en Brevo', [
                'error' => $e->getMessage(),
                'email' => $email,
            ]);
            return false;
        }
    }
}
