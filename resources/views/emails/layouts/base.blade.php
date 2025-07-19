<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? config('app.name') }}</title>
    <style>
        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .email-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .email-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-top: 5px;
        }

        /* Contenido */
        .email-content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .content-text {
            font-size: 16px;
            line-height: 1.8;
            color: #374151;
            margin-bottom: 20px;
        }

        .content-text strong {
            color: #1f2937;
            font-weight: 600;
        }

        /* Botones */
        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: transform 0.2s;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        /* Alertas y cajas */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid;
        }

        .alert-info {
            background-color: #eff6ff;
            border-color: #3b82f6;
            color: #1e40af;
        }

        .alert-warning {
            background-color: #fffbeb;
            border-color: #f59e0b;
            color: #92400e;
        }

        .alert-success {
            background-color: #f0fdf4;
            border-color: #10b981;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }

        /* Listas */
        .product-list {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-name {
            font-weight: 600;
            color: #1f2937;
        }

        .product-details {
            font-size: 14px;
            color: #6b7280;
        }

        .stock-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-low {
            background: #fef3c7;
            color: #92400e;
        }

        .stock-out {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Footer */
        .email-footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 20px;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }

            .email-header,
            .email-content,
            .email-footer {
                padding: 20px;
            }

            .email-title {
                font-size: 20px;
            }

            .button {
                padding: 12px 24px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo">
                @yield('icon', '📦')
            </div>
            <h1 class="email-title">@yield('title', config('app.name'))</h1>
            @hasSection('subtitle')
                <p class="email-subtitle">@yield('subtitle')</p>
            @endif
        </div>

        <!-- Contenido -->
        <div class="email-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p class="footer-text">
                Este email fue enviado desde <strong>{{ config('app.name') }}</strong>
            </p>
            <p class="footer-text">
                © {{ date('Y') }} Todos los derechos reservados.
            </p>
            @hasSection('footer-links')
                <div class="footer-links">
                    @yield('footer-links')
                </div>
            @endif
        </div>
    </div>
</body>
</html>
