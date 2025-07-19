@extends('emails.layouts.base')

@section('icon')
    @if($movement->type == 'in') 📥
    @elseif($movement->type == 'out') 📤
    @else ⚙️
    @endif
@endsection

@section('title', 'Movimiento de Stock')
@section('subtitle', $movement->type_text . ' registrado en el inventario')

@section('content')
    <div class="greeting">
        ¡Hola {{ $user->name }}!
    </div>

    <div class="content-text">
        Se ha registrado un <strong>{{ $movement->type_text }}</strong> en el inventario:
    </div>

    <div class="product-list">
        <div class="product-item">
            <div>
                <div class="product-name">🏷️ {{ $movement->product->name }}</div>
                <div class="product-details">{{ $movement->product->category->name }}</div>
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
            <div>
                <strong>🔢 Cantidad:</strong><br>
                {{ $movement->quantity }} unidades
            </div>
            <div>
                <strong>📊 Stock anterior:</strong><br>
                {{ $movement->previous_stock }}
            </div>
            <div>
                <strong>📈 Stock actual:</strong><br>
                {{ $movement->new_stock }}
            </div>
            <div>
                <strong>⏰ Fecha:</strong><br>
                {{ $movement->created_at->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>

    @if($movement->reason)
        <div class="content-text">
            <strong>📝 Motivo:</strong> {{ $movement->reason }}
        </div>
    @endif

    @if($movement->reference)
        <div class="content-text">
            <strong>🔗 Referencia:</strong> {{ $movement->reference }}
        </div>
    @endif

    @if($movement->new_stock <= $movement->product->min_stock_level)
        <div class="alert alert-warning">
            <strong>⚠️ Atención:</strong> Este producto ahora tiene stock bajo. Considera reabastecerlo pronto.
        </div>
    @endif

    <div class="button-container">
        <a href="{{ route('products.show', $movement->product) }}" class="button">
            📊 Ver Detalles del Producto
        </a>
    </div>
@endsection

@section('footer-links')
    <a href="{{ route('products.show', $movement->product) }}">Ver Producto</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
@endsection
