@extends('emails.layouts.base')

@section('icon', '🔐')
@section('title', 'Restablecer Contraseña')
@section('subtitle', 'Solicitud de restablecimiento de contraseña')

@section('content')
    <div class="greeting">
        ¡Hola!
    </div>

    <div class="content-text">
        Recibiste este email porque se solicitó un restablecimiento de contraseña para tu cuenta.
    </div>

    <div class="button-container">
        <a href="{{ $actionUrl }}" class="button">
            🔑 Restablecer Contraseña
        </a>
    </div>

    <div class="alert alert-info">
        <strong>⏰ Importante:</strong> Este enlace de restablecimiento expirará en {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutos.
    </div>

    <div class="content-text">
        Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.
    </div>

    <div class="alert alert-warning">
        <strong>🔒 Seguridad:</strong> Si tienes problemas haciendo clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu navegador web:
        <br><br>
        <a href="{{ $actionUrl }}" style="word-break: break-all;">{{ $actionUrl }}</a>
    </div>
@endsection
