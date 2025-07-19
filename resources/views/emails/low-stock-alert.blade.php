@extends('emails.layouts.base')

@section('icon', '⚠️')
@section('title', 'Alerta de Stock Bajo')
@section('subtitle', 'Productos que requieren atención inmediata')

@section('content')
    <div class="greeting">
        ¡Hola {{ $user->name }}!
    </div>

    <div class="content-text">
        Tienes <strong>{{ $products->count() }} producto(s)</strong> con stock bajo que requieren atención inmediata.
    </div>

    <div class="alert alert-warning">
        <strong>⚠️ Atención:</strong> Los siguientes productos necesitan ser reabastecidos pronto para evitar interrupciones en las ventas.
    </div>

    <div class="content-text">
        <strong>📦 Productos afectados:</strong>
    </div>

    <div class="product-list">
        @foreach($products as $product)
            <div class="product-item">
                <div>
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-details">
                        Categoría: {{ $product->category->name }} |
                        Stock actual: {{ $product->stock_quantity }} |
                        Mínimo: {{ $product->min_stock_level }}
                    </div>
                </div>
                <div>
                    @if($product->stock_quantity == 0)
                        <span class="stock-status stock-out">🔴 SIN STOCK</span>
                    @else
                        <span class="stock-status stock-low">🟡 STOCK BAJO</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="button-container">
        <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="button">
            🔍 Ver Productos con Stock Bajo
        </a>
    </div>

    <div class="alert alert-info">
        <strong>💡 Recomendación:</strong> Te sugerimos reabastecer estos productos lo antes posible para evitar interrupciones en las ventas.
    </div>

    <div class="content-text">
        📊 Puedes revisar el dashboard para obtener más información sobre el estado de tu inventario.
    </div>
@endsection

@section('footer-links')
    <a href="{{ route('products.index', ['low_stock' => 1]) }}">Ver Stock Bajo</a>
    <a href="{{ route('dashboard') }}">Dashboard</a>
@endsection
