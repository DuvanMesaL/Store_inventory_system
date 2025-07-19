@extends('layouts.app')

@section('title', $supplier->name . ' - Sistema de Inventario')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('suppliers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-truck mr-2"></i>{{ $supplier->name }}
            </h1>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline"
                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este proveedor?')">
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
            <!-- Detalles del proveedor -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>Información del Proveedor
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $supplier->name }}</p>
                    </div>

                    @if($supplier->company)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                        <p class="text-gray-900">{{ $supplier->company }}</p>
                    </div>
                    @endif

                    @if($supplier->email)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <a href="mailto:{{ $supplier->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $supplier->email }}
                        </a>
                    </div>
                    @endif

                    @if($supplier->phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <a href="tel:{{ $supplier->phone }}" class="text-blue-600 hover:text-blue-800">
                            {{ $supplier->phone }}
                        </a>
                    </div>
                    @endif

                    @if($supplier->website)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sitio Web</label>
                        <a href="{{ $supplier->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            {{ $supplier->website }} <i class="fas fa-external-link-alt ml-1"></i>
                        </a>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Registro</label>
                        <p class="text-gray-900">{{ $supplier->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($supplier->address)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                    <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $supplier->address }}</p>
                </div>
                @endif

                @if($supplier->notes)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                    <p class="text-gray-900 bg-gray-50 p-4 rounded-lg">{{ $supplier->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Productos del proveedor -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">
                        <i class="fas fa-boxes mr-2"></i>Productos del Proveedor
                    </h2>
                    <span class="text-sm text-gray-500">{{ $supplier->products->count() }} productos</span>
                </div>

                @if($supplier->products->count() > 0)
                    <div class="space-y-3">
                        @foreach($supplier->products->take(10) as $product)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-box text-blue-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">Stock: {{ $product->stock_quantity }}</div>
                                    <div class="text-sm text-gray-500">${{ number_format($product->selling_price, 2) }}</div>
                                </div>
                                <div>
                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($supplier->products->count() > 10)
                        <div class="mt-4 text-center">
                            <a href="{{ route('products.index', ['supplier_id' => $supplier->id]) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Ver todos los productos ({{ $supplier->products->count() }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-box-open text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-500">No hay productos asociados a este proveedor</p>
                        <a href="{{ route('products.create', ['supplier_id' => $supplier->id]) }}"
                           class="mt-3 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i>Agregar Producto
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-chart-bar mr-2"></i>Estadísticas
                </h3>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total productos:</span>
                        <span class="font-bold text-blue-600">{{ $supplier->products->count() }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Valor inventario:</span>
                        <span class="font-bold text-green-600">
                            ${{ number_format($supplier->products->sum(function($product) {
                                return $product->stock_quantity * $product->purchase_price;
                            }), 2) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Productos con stock bajo:</span>
                        <span class="font-bold text-red-600">
                            {{ $supplier->products->filter(function($product) {
                                return $product->isLowStock();
                            })->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Última actualización:</span>
                        <span class="text-sm text-gray-500">{{ $supplier->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-bolt mr-2"></i>Acciones Rápidas
                </h3>

                <div class="space-y-3">
                    <a href="{{ route('products.create', ['supplier_id' => $supplier->id]) }}"
                       class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                        <i class="fas fa-plus mr-2"></i>Agregar Producto
                    </a>

                    <a href="{{ route('products.index', ['supplier_id' => $supplier->id]) }}"
                       class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                        <i class="fas fa-boxes mr-2"></i>Ver Productos
                    </a>

                    <a href="{{ route('suppliers.edit', $supplier) }}"
                       class="block w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                        <i class="fas fa-edit mr-2"></i>Editar Proveedor
                    </a>

                    @if($supplier->email)
                    <a href="mailto:{{ $supplier->email }}"
                       class="block w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                        <i class="fas fa-envelope mr-2"></i>Enviar Email
                    </a>
                    @endif
                </div>
            </div>

            <!-- Información de contacto -->
            @if($supplier->email || $supplier->phone || $supplier->website)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-address-card mr-2"></i>Contacto Rápido
                </h3>

                <div class="space-y-3">
                    @if($supplier->email)
                    <a href="mailto:{{ $supplier->email }}"
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-envelope text-blue-600 mr-3"></i>
                        <span class="text-gray-900">{{ $supplier->email }}</span>
                    </a>
                    @endif

                    @if($supplier->phone)
                    <a href="tel:{{ $supplier->phone }}"
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-phone text-green-600 mr-3"></i>
                        <span class="text-gray-900">{{ $supplier->phone }}</span>
                    </a>
                    @endif

                    @if($supplier->website)
                    <a href="{{ $supplier->website }}" target="_blank"
                       class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-globe text-purple-600 mr-3"></i>
                        <span class="text-gray-900">Sitio Web</span>
                        <i class="fas fa-external-link-alt ml-auto text-gray-400"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
