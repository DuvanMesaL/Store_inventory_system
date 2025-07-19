@extends('emails.layouts.base')

@section('icon', '🎉')
@section('title', '¡Bienvenido!')
@section('subtitle', 'Tu cuenta ha sido creada exitosamente')

@section('content')
    <div class="greeting">
        ¡Hola {{ $user->name }}! 👋
    </div>

    <div class="content-text">
        ¡Te damos la más cordial <strong>bienvenida</strong> a nuestro Sistema de Inventario! 🚀
    </div>

    <div class="content-text">
        Tu cuenta ha sido creada exitosamente y ya puedes comenzar a gestionar el inventario de tu tienda de manera eficiente.
    </div>

    <div class="alert alert-info">
        <strong>🎯 Tu rol actual:</strong> {{ ucfirst($user->role) }}
    </div>

    <div class="content-text">
        <strong>🌟 Características principales que puedes usar:</strong>
    </div>

    <div class="product-list">
        <div class="product-item">
            <div>
                <div class="product-name">📦 Gestión completa de productos</div>
                <div class="product-details">Agregar, editar y organizar tu inventario</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">📊 Control de stock en tiempo real</div>
                <div class="product-details">Monitoreo automático de existencias</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">⚠️ Alertas automáticas de stock bajo</div>
                <div class="product-details">Nunca te quedes sin productos</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">📈 Reportes y estadísticas detalladas</div>
                <div class="product-details">Análisis completo de tu inventario</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">🏷️ Organización por categorías</div>
                <div class="product-details">Mantén todo ordenado y fácil de encontrar</div>
            </div>
        </div>
        <div class="product-item">
            <div>
                <div class="product-name">🚚 Gestión de proveedores</div>
                <div class="product-details">Control completo de tus socios comerciales</div>
            </div>
        </div>
    </div>

    <div class="button-container">
        <a href="{{ route('dashboard') }}" class="button">
            🚀 Acceder al Sistema
        </a>
    </div>

    <div class="alert alert-success">
        <strong>💡 Consejo:</strong> Comienza creando algunas categorías y luego agrega tus primeros productos.
    </div>

    <div class="content-text">
        📞 Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos. ¡Estamos aquí para apoyarte!
    </div>
@endsection

@section('footer-links')
    <a href="{{ route('dashboard') }}">Ir al Dashboard</a>
    <a href="mailto:{{ config('mail.from.address') }}">Contacto</a>
@endsection
