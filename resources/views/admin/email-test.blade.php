@extends('layouts.app')

@section('title', 'Pruebas de Email - Sistema de Inventario')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-envelope-open-text mr-3"></i>Pruebas de Email
                </h1>
                <p class="text-gray-600 mt-2">Prueba la configuración de Brevo SMTP y envía emails de prueba</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Configuración actual</div>
                <div class="text-lg font-semibold text-gray-700">Brevo SMTP</div>
            </div>
        </div>

        <!-- Estado de conexión -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-wifi mr-2"></i>Estado de Conexión
                </h2>
                <button onclick="testConnection()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-sync-alt mr-2"></i>Probar Conexión
                </button>
            </div>

            <div id="connection-status" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Host SMTP</div>
                    <div class="font-semibold">{{ config('mail.mailers.smtp.host') }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Puerto</div>
                    <div class="font-semibold">{{ config('mail.mailers.smtp.port') }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Encriptación</div>
                    <div class="font-semibold">{{ strtoupper(config('mail.mailers.smtp.encryption')) }}</div>
                </div>
            </div>
        </div>

        <!-- Formulario de pruebas -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                <i class="fas fa-paper-plane mr-2"></i>Enviar Email de Prueba
            </h2>

            <form action="{{ route('admin.email.test') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email de Destino
                        </label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-list mr-2"></i>Tipo de Email
                        </label>
                        <select name="type" id="type" required onchange="toggleCustomFields()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="basic">🧪 Prueba Básica</option>
                            <option value="welcome">🎉 Email de Bienvenida</option>
                            <option value="low_stock">⚠️ Alerta de Stock Bajo</option>
                            <option value="custom">✏️ Email Personalizado</option>
                        </select>
                    </div>
                </div>

                <!-- Campos para email personalizado -->
                <div id="custom-fields" class="space-y-4" style="display: none;">
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-heading mr-2"></i>Asunto
                        </label>
                        <input type="text" name="subject" id="subject"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Asunto del email personalizado">
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-2"></i>Contenido
                        </label>
                        <textarea name="content" id="content" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Contenido del email personalizado..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Enviar Email de Prueba
                    </button>
                </div>
            </form>
        </div>

        <!-- Estadísticas de email -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-chart-bar mr-2"></i>Estadísticas de Email (Últimos 30 días)
                </h2>
                <button onclick="loadEmailStats()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    <i class="fas fa-refresh mr-2"></i>Actualizar
                </button>
            </div>

            <div id="email-stats" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600" id="emails-sent">-</div>
                    <div class="text-sm text-gray-600">Emails Enviados</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600" id="emails-delivered">-</div>
                    <div class="text-sm text-gray-600">Entregados</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600" id="emails-opened">-</div>
                    <div class="text-sm text-gray-600">Abiertos</div>
                </div>
                <div class="bg-red-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-600" id="emails-bounced">-</div>
                    <div class="text-sm text-gray-600">Rebotados</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCustomFields() {
    const type = document.getElementById('type').value;
    const customFields = document.getElementById('custom-fields');

    if (type === 'custom') {
        customFields.style.display = 'block';
    } else {
        customFields.style.display = 'none';
    }
}

async function testConnection() {
    const button = event.target;
    const originalText = button.innerHTML;

    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Probando...';
    button.disabled = true;

    try {
        const response = await fetch('{{ route("admin.email.test-connection") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        alert('❌ Error de conexión: ' + error.message);
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

async function loadEmailStats() {
    try {
        const response = await fetch('{{ route("admin.email.stats") }}');
        const data = await response.json();

        if (data) {
            document.getElementById('emails-sent').textContent = data.sent || 0;
            document.getElementById('emails-delivered').textContent = data.delivered || 0;
            document.getElementById('emails-opened').textContent = data.opened || 0;
            document.getElementById('emails-bounced').textContent = data.bounced || 0;
        }
    } catch (error) {
        console.error('Error loading email stats:', error);
    }
}

// Cargar estadísticas al cargar la página
document.addEventListener('DOMContentLoaded', loadEmailStats);
</script>
@endsection
