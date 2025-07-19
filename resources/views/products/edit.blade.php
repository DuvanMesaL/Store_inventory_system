@extends('layouts.app')

@section('title', 'Editar Producto - Sistema de Inventario')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-edit mr-2"></i>Editar Producto
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('products.show', $product) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-eye mr-2"></i>Ver
            </a>
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Volver
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Información Básica</h3>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre del Producto *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sku') border-red-500 @enderror">
                        @error('sku')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">Código de Barras</label>
                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('barcode') border-red-500 @enderror">
                        @error('barcode')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Clasificación y precios -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Clasificación y Precios</h3>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                        <select name="category_id" id="category_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Seleccionar categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">Proveedor *</label>
                        <select name="supplier_id" id="supplier_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('supplier_id') border-red-500 @enderror">
                            <option value="">Seleccionar proveedor</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">Precio de Compra *</label>
                            <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                                   step="0.01" min="0" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('purchase_price') border-red-500 @enderror">
                            @error('purchase_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-2">Precio de Venta *</label>
                            <input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                                   step="0.01" min="0" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('selling_price') border-red-500 @enderror">
                            @error('selling_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Actual</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                   min="0" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">Use los movimientos de stock para cambiar esta cantidad</p>
                        </div>

                        <div>
                            <label for="min_stock_level" class="block text-sm font-medium text-gray-700 mb-2">Stock Mínimo *</label>
                            <input type="number" name="min_stock_level" id="min_stock_level" value="{{ old('min_stock_level', $product->min_stock_level) }}"
                                   min="0" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('min_stock_level') border-red-500 @enderror">
                            @error('min_stock_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información calculada -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">Información Calculada</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Margen actual:</span>
                                <span class="font-medium" id="current-margin">{{ number_format($product->margin, 1) }}%</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Ganancia por unidad:</span>
                                <span class="font-medium text-green-600" id="unit-profit">${{ number_format($product->selling_price - $product->purchase_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                <a href="{{ route('products.show', $product) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    <i class="fas fa-save mr-2"></i>Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Calcular margen automáticamente
document.addEventListener('DOMContentLoaded', function() {
    const purchasePrice = document.getElementById('purchase_price');
    const sellingPrice = document.getElementById('selling_price');
    const marginDisplay = document.getElementById('current-margin');
    const profitDisplay = document.getElementById('unit-profit');

    function calculateMargin() {
        const purchase = parseFloat(purchasePrice.value) || 0;
        const selling = parseFloat(sellingPrice.value) || 0;

        if (selling > 0) {
            const margin = ((selling - purchase) / selling) * 100;
            const profit = selling - purchase;

            marginDisplay.textContent = margin.toFixed(1) + '%';
            profitDisplay.textContent = '$' + profit.toFixed(2);

            // Cambiar color según el margen
            if (margin < 10) {
                marginDisplay.className = 'font-medium text-red-600';
            } else if (margin < 20) {
                marginDisplay.className = 'font-medium text-yellow-600';
            } else {
                marginDisplay.className = 'font-medium text-green-600';
            }
        }
    }

    purchasePrice.addEventListener('input', calculateMargin);
    sellingPrice.addEventListener('input', calculateMargin);
});
</script>
@endsection
