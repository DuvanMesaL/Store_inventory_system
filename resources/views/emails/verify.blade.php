@extends('emails.layouts.base')

@section('icon', '✉️')
@section('title', 'Verificar Email')
@section('subtitle', 'Confirma tu dirección de correo electrónico')

@section('content')
    <div class="greeting">
        ¡Hola {{ $user->name }}!
    </div>

    <div class="content-text">
        Gracias por registrarte en nuestro <strong>Sistema de Inventario</strong>. Para completar tu registro, necesitamos verificar tu dirección de correo electrónico.
    </div>

    <div class="button-container">
        <a href="{{ $actionUrl }}" class="button">
            ✅ Verificar Mi Email
        </a>
    </div>

    <div class="alert alert-info">
        <strong>🔒 Seguridad:</strong> Este enlace expirará en 60 minutos por motivos de seguridad.
    </div>

    <div class="content-text">
        Si no creaste esta cuenta, puedes ignorar este email de forma segura.
    </div>

    <div class="alert alert-warning">
        <strong>💡 Consejo:</strong> Si tienes problemas haciendo clic en el botón, copia y pega la siguiente URL en tu navegador:
        <br><br>
        <a href="{{ $actionUrl }}" style="word-break: break-all;">{{ $actionUrl }}</a>
    </div>
@endsection

@section('footer-links')
    <a href="{{ route('login') }}">Iniciar Sesión</a>
    <a href="mailto:{{ config('mail.from.address') }}">Contacto</a>
@endsection
