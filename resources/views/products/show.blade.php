@extends('layouts.app')

@section('title', $product->name . ' - Sistema de Inventario')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-box mr-2"></i>{{ $product->name }}
            </h1>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('products.edit', $product) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-trash mr-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles del producto -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Información del Producto
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <p class="text-gray-900 font-mono">{{ $product->sku }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-tag mr-1"></i>{{ $product->category->name }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                        <p class="text-gray-900">{{ $product->supplier->name }}</p>
                    </div>

                    @if($product->barcode)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Código de Barras</label>
                        <p class="text-gray-900 font-mono">{{ $product->barcode }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Creación</label>
                        <p class="text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($product->description)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $product->description }}</p>
                </div>
                @endif
            </div>

            <!-- Precios y márgenes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-dollar-sign mr-2"></i>Precios y Rentabilidad
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">${{ number_format($product->purchase_price, 2) }}</div>
                        <div class="text-sm text-gray-600">Precio de Compra</div>
                    </div>

                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">${{ number_format($product->selling_price, 2) }}</div>
                        <div class="text-sm text-gray-600">Precio de Venta</div>
                    </div>

                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($product->margin, 1) }}%</div>
                        <div class="text-sm text-gray-600">Margen de Ganancia</div>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700">Ganancia por unidad:</span>
                        <span class="font-bold text-green-600">${{ number_format($product->selling_price - $product->purchase_price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Movimientos recientes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-history mr-2"></i>Movimientos Recientes
                    </h2>
                    <span class="text-sm text-gray-500">Últimos 10 movimientos</span>
                </div>

                @if($product->stockMovements->count() > 0)
                    <div class="space-y-3">
                        @foreach($product->stockMovements->take(10) as $movement)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3
                                        @if($movement->type == 'in') bg-green-100 text-green-600
                                        @elseif($movement->type == 'out') bg-red-100 text-red-600
                                        @else bg-blue-100 text-blue-600 @endif">
                                        @if($movement->type == 'in')
                                            <i class="fas fa-arrow-up text-xs"></i>
                                        @elseif($movement->type == 'out')
                                            <i class="fas fa-arrow-down text-xs"></i>
                                        @else
                                            <i class="fas fa-edit text-xs"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $movement->type_text }}</div>
                                        <div class="text-sm text-gray-500">{{ $movement->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900">{{ $movement->quantity }} unidades</div>
                                    <div class="text-sm text-gray-500">Stock: {{ $movement->new_stock }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No hay movimientos registrados</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estado del stock -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-warehouse mr-2"></i>Estado del Stock
                </h3>

                <div class="text-center mb-4">
                    <div class="text-4xl font-bold mb-2
                        @if($product->stock_quantity == 0) text-red-600
                        @elseif($product->isLowStock()) text-yellow-600
                        @else text-green-600 @endif">
                        {{ $product->stock_quantity }}
                    </div>
                    <div class="text-sm text-gray-600">Unidades disponibles</div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Stock mínimo:</span>
                        <span class="font-medium">{{ $product->min_stock_level }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Estado:</span>
                        @if($product->stock_quantity == 0)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Sin Stock
                            </span>
                        @elseif($product->isLowStock())
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Stock Bajo
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>En Stock
                            </span>
                        @endif
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Valor en inventario:</span>
                        <span class="font-bold text-green-600">${{ number_format($product->stock_quantity * $product->purchase_price, 2) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Valor potencial:</span>
                        <span class="font-bold text-blue-600">${{ number_format($product->stock_quantity * $product->selling_price, 2) }}</span>
                    </div>
                </div>

                @if($product->isLowStock())
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                        <span class="text-sm text-yellow-800">Este producto necesita ser reabastecido</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Acciones rápidas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-bolt mr-2"></i>Acciones Rápidas
                </h3>

                <div class="space-y-3">
                    <button onclick="showStockModal('in')" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i>Agregar Stock
                    </button>

                    <button onclick="showStockModal('out')" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-minus mr-2"></i>Reducir Stock
                    </button>

                    <a href="{{ route('products.edit', $product) }}" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                        <i class="fas fa-edit mr-2"></i>Editar Producto
                    </a>
                </div>
            </div>

            <!-- Información del proveedor -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-truck mr-2"></i>Proveedor
                </h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <p class="text-gray-900">{{ $product->supplier->name }}</p>
                    </div>

                    @if($product->supplier->email)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <a href="mailto:{{ $product->supplier->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $product->supplier->email }}
                        </a>
                    </div>
                    @endif

                    @if($product->supplier->phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <a href="tel:{{ $product->supplier->phone }}" class="text-blue-600 hover:text-blue-800">
                            {{ $product->supplier->phone }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para movimientos de stock -->
<div id="stockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Movimiento de Stock</h3>
                <button onclick="hideStockModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="stockForm" method="POST" action="{{ route('products.stock-movement', $product) }}">
                @csrf
                <input type="hidden" name="type" id="movementType">

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                    <input type="number" name="quantity" id="quantity" min="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Motivo</label>
                    <textarea name="reason" id="reason" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe el motivo del movimiento..."></textarea>
                </div>

                <div class="mb-4">
                    <label for="reference" class="block text-sm font-medium text-gray-700 mb-2">Referencia (opcional)</label>
                    <input type="text" name="reference" id="reference"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Número de factura, orden, etc.">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideStockModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancelar
                    </button>
                    <button type="submit" id="submitBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showStockModal(type) {
    const modal = document.getElementById('stockModal');
    const title = document.getElementById('modalTitle');
    const typeInput = document.getElementById('movementType');
    const submitBtn = document.getElementById('submitBtn');

    typeInput.value = type;

    if (type === 'in') {
        title.textContent = 'Agregar Stock';
        submitBtn.textContent = 'Agregar Stock';
        submitBtn.className = 'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded';
    } else {
        title.textContent = 'Reducir Stock';
        submitBtn.textContent = 'Reducir Stock';
        submitBtn.className = 'bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded';
    }

    modal.classList.remove('hidden');
}

function hideStockModal() {
    const modal = document.getElementById('stockModal');
    modal.classList.add('hidden');

    // Limpiar formulario
    document.getElementById('stockForm').reset();
}

// Cerrar modal al hacer clic fuera
document.getElementById('stockModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideStockModal();
    }
});
</script>
@endsection
