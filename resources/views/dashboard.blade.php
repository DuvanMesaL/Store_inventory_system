@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Inventario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header con saludo personalizado -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    ¡Hola, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-gray-600 text-lg">Aquí tienes un resumen de tu inventario</p>
            </div>
            <div class="mt-4 md:mt-0 text-right">
                <div class="text-sm text-gray-500">{{ now()->format('l, d \d\e F \d\e Y') }}</div>
                <div class="text-lg font-semibold text-gray-700">{{ now()->format('H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de estadísticas mejoradas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Productos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>+12% este mes
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-boxes text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Categorías</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalCategories }}</p>
                    <p class="text-xs text-blue-600 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Activas
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Proveedores</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalSuppliers }}</p>
                    <p class="text-xs text-purple-600 mt-1">
                        <i class="fas fa-handshake mr-1"></i>Colaboradores
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-truck text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 card-hover border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Stock Bajo</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $lowStockProducts }}</p>
                    <p class="text-xs text-red-600 mt-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Requiere atención
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Valores del inventario con diseño mejorado -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2 opacity-90">
                        <i class="fas fa-dollar-sign mr-2"></i>Valor del Inventario
                    </h3>
                    <p class="text-3xl font-bold mb-1">${{ number_format($totalInventoryValue, 2) }}</p>
                    <p class="text-sm opacity-80">Valor total de compra del stock actual</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-warehouse text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2 opacity-90">
                        <i class="fas fa-chart-line mr-2"></i>Valor Potencial
                    </h3>
                    <p class="text-3xl font-bold mb-1">${{ number_format($totalSalesValue, 2) }}</p>
                    <p class="text-sm opacity-80">Valor si se vende todo el stock</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trending-up text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Productos con stock bajo mejorado -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Productos con Stock Bajo
                </h2>
                @if($lowStockProducts > 0)
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $lowStockProducts }} alertas
                    </span>
                @endif
            </div>

            @if($lowStockItems->count() > 0)
                <div class="space-y-4">
                    @foreach($lowStockItems as $item)
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-100 hover:bg-red-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-200 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-box text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-tag mr-1"></i>{{ $item->category->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-red-600">{{ $item->stock_quantity }}</p>
                                <p class="text-xs text-gray-500">Mín: {{ $item->min_stock_level }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    <a href="{{ route('products.index', ['low_stock' => 1]) }}"
                       class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Ver todos los productos con stock bajo
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">¡Excelente!</h3>
                    <p class="text-gray-600">No hay productos con stock bajo.</p>
                </div>
            @endif
        </div>

        <!-- Movimientos recientes mejorado -->
        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-history mr-2"></i>Movimientos Recientes
                </h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Últimos 10
                </span>
            </div>

            @if($recentMovements->count() > 0)
                <div class="space-y-4">
                    @foreach($recentMovements as $movement)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3
                                    @if($movement->type == 'in') bg-green-100 @elseif($movement->type == 'out') bg-red-100 @else bg-blue-100 @endif">
                                    @if($movement->type == 'in')
                                        <i class="fas fa-arrow-up text-green-600"></i>
                                    @elseif($movement->type == 'out')
                                        <i class="fas fa-arrow-down text-red-600"></i>
                                    @else
                                        <i class="fas fa-edit text-blue-600"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $movement->product->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        <span class="
                                            @if($movement->type == 'in') text-green-600
                                            @elseif($movement->type == 'out') text-red-600
                                            @else text-blue-600 @endif">
                                            {{ $movement->type_text }}
                                        </span>
                                        - {{ $movement->quantity }} unidades
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $movement->created_at->format('H:i') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $movement->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sin movimientos</h3>
                    <p class="text-gray-600">No hay movimientos recientes registrados.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Estadísticas por categoría mejoradas -->
    @if($categoryStats->count() > 0)
    <div class="bg-white rounded-xl shadow-lg p-6 mt-8 card-hover">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fas fa-chart-pie mr-2"></i>Distribución por Categorías
            </h2>
            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $categoryStats->count() }} categorías
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categoryStats as $category)
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-4 border border-purple-100 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                            <p class="text-sm text-gray-600">{{ $category->products_count }} productos</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-lg font-bold text-purple-600">{{ $category->products_count }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Acciones rápidas -->
    <div class="bg-white rounded-xl shadow-lg p-6 mt-8 card-hover">
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            <i class="fas fa-bolt mr-2"></i>Acciones Rápidas
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('products.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Nuevo Producto</p>
                    <p class="text-xs text-gray-600">Agregar al inventario</p>
                </div>
            </a>

            @if(auth()->user()->canManageProducts())
            <a href="{{ route('categories.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tag text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Nueva Categoría</p>
                    <p class="text-xs text-gray-600">Organizar productos</p>
                </div>
            </a>

            <a href="{{ route('suppliers.create') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors group">
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-truck text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Nuevo Proveedor</p>
                    <p class="text-xs text-gray-600">Gestionar proveedores</p>
                </div>
            </a>
            @endif

            <a href="{{ route('products.index', ['low_stock' => 1]) }}" class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors group">
                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Stock Bajo</p>
                    <p class="text-xs text-gray-600">Revisar alertas</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
