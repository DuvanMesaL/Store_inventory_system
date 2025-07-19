@extends('emails.layouts.base')

@section('icon', '🧪')
@section('title', 'Email de Prueba')
@section('subtitle', 'Verificación de configuración SMTP')

@section('content')
    <div class="greeting">
        ¡Hola!
    </div>

    <div class="content-text">
        Este es un email de prueba para verificar que la configuración de Brevo SMTP está funcionando correctamente.
    </div>

    <div class="alert alert-success">
        <strong>✅ ¡Excelente!</strong> Si estás leyendo este mensaje, significa que la configuración de email está funcionando perfectamente.
    </div>

    <div class="product-list">
        <div class="product-item">
            <div>
                <div class="product-name">📧 Servidor SMTP</div>
                <div class="product-details">{{ config('mail.mailers.smtp.host') }}:{{ config('mail.mailers.smtp.port') }}</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">🔐 Encriptación</div>
                <div class="product-details">{{ strtoupper(config('mail.mailers.smtp.encryption')) }}</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">📅 Fecha de prueba</div>
                <div class="product-details">{{ now()->format('d/m/Y H:i:s') }}</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">🚀 Sistema</div>
                <div class="product-details">Laravel + Brevo SMTP</div>
            </div>
        </div>
    </div>

    <div class="button-container">
        <a href="{{ route('dashboard') }}" class="button">
            🏠 Ir al Dashboard
        </a>
    </div>

    <div class="content-text">
        Ahora puedes estar seguro de que todas las notificaciones del sistema (alertas de stock bajo, emails de bienvenida, etc.) se enviarán correctamente.
    </div>
@endsection

@section('footer-links')
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.email.index') }}">Panel de Emails</a>
@endsection
