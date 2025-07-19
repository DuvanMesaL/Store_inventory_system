<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Email - Sistema de Inventario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo y título -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-envelope-open-text text-2xl text-purple-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Verificar Email</h1>
            <p class="text-purple-100">Confirma tu dirección de correo electrónico</p>
        </div>

        <!-- Contenido principal -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8">
            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif

            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-blue-600 text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">
                    ¡Casi terminamos!
                </h2>
                <p class="text-gray-600">
                    Hemos enviado un enlace de verificación a:
                </p>
                <p class="font-semibold text-gray-900 mt-2">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Instrucciones
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Revisa tu bandeja de entrada</li>
                                <li>Busca el email de verificación</li>
                                <li>Haz clic en el enlace de verificación</li>
                                <li>Regresa aquí para continuar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario para reenviar -->
            <form method="POST" action="{{ route('verification.resend') }}" class="space-y-4">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:from-purple-700 hover:to-blue-700 focus:ring-4 focus:ring-purple-200 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-paper-plane mr-2"></i>Reenviar Email de Verificación
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 mb-4">
                    ¿No recibiste el email? Revisa tu carpeta de spam.
                </p>

                <div class="flex justify-center space-x-4">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="fas fa-sign-out-alt mr-1"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-purple-100 text-sm">
                © {{ date('Y') }} Sistema de Inventario. Todos los derechos reservados.
            </p>
        </div>
    </div>

    <script>
        // Auto-refresh cada 30 segundos para verificar si el email fue verificado
        setInterval(function() {
            fetch('{{ route('verification.notice') }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            });
        }, 30000);
    </script>
</body>
</html>
