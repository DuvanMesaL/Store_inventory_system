@extends('layouts.app')

@section('title', 'Error del Servidor - Sistema de Inventario')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <div class="mx-auto h-32 w-32 bg-red-100 rounded-full flex items-center justify-center mb-8">
                <i class="fas fa-exclamation-triangle text-red-600 text-6xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Error del Servidor
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Algo salió mal en nuestros servidores. Estamos trabajando para solucionarlo.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tools text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Estamos en ello
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>Nuestro equipo técnico ha sido notificado y está trabajando para resolver este problema.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-home mr-2"></i>
                    Ir al Dashboard
                </a>

                <button onclick="location.reload()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-redo mr-2"></i>
                    Intentar de Nuevo
                </button>
            </div>
        </div>

        <div class="mt-8 text-sm text-gray-500">
            <p>Si el problema persiste, contacta al administrador del sistema.</p>
        </div>
    </div>
</div>
@endsection
