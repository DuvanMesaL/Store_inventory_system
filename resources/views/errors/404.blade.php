@extends('layouts.app')

@section('title', 'Página No Encontrada - Sistema de Inventario')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <div class="mx-auto h-32 w-32 bg-blue-100 rounded-full flex items-center justify-center mb-8">
                <i class="fas fa-search text-blue-600 text-6xl"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">
                Página No Encontrada
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                La página que buscas no existe o ha sido movida.
            </p>
        </div>

        <div class="space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            ¿Qué puedes hacer?
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Verifica la URL en la barra de direcciones</li>
                                <li>Regresa al dashboard principal</li>
                                <li>Usa el menú de navegación</li>
                            </ul>
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

                <button onclick="history.back()"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver Atrás
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
