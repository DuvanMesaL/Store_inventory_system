# 📦 Sistema de Inventario Laravel

Un sistema completo de gestión de inventario para tiendas locales desarrollado con Laravel 9, que incluye autenticación, control de stock, notificaciones por email y un dashboard interactivo.

## 🚀 Características Principales

### 🔐 **Autenticación y Seguridad**
- Sistema de registro y login completo
- Verificación de email obligatoria
- Recuperación de contraseñas
- Middleware de autenticación
- Roles y permisos básicos

### 📊 **Dashboard Inteligente**
- Estadísticas en tiempo real del inventario
- Productos con stock bajo (alertas visuales)
- Movimientos recientes de stock
- Valor total del inventario
- Gráficos y métricas importantes

### 🛍️ **Gestión de Productos**
- CRUD completo con validaciones
- Control de stock automático
- Códigos SKU únicos
- Gestión de precios (costo, venta, margen)
- Alertas automáticas de stock bajo
- Filtros y búsqueda avanzada
- Modal para ajustes rápidos de stock

### 📂 **Categorías y Proveedores**
- Organización por categorías
- Gestión completa de proveedores
- Información de contacto detallada
- Estadísticas por categoría y proveedor

### 📈 **Control de Stock Avanzado**
- Movimientos automáticos (entrada, salida, ajuste)
- Historial completo de movimientos
- Razones para cada movimiento
- Alertas automáticas de stock bajo
- Validaciones para evitar stock negativo

### 📧 **Sistema de Notificaciones**
- Integración completa con Brevo (SendinBlue)
- Emails de bienvenida automáticos
- Alertas de stock bajo por email
- Notificaciones de movimientos importantes
- Plantillas de email personalizadas
- Verificación de email obligatoria

### 🎨 **Interfaz de Usuario**
- Diseño responsive con Tailwind CSS
- Interfaz moderna y intuitiva
- Iconos Font Awesome
- Alertas visuales y notificaciones
- Modales interactivos
- Tablas con paginación

## 📋 Requisitos del Sistema

- **PHP** >= 8.0
- **Composer** >= 2.0
- **MySQL/MariaDB** >= 5.7
- **Node.js** >= 14 (opcional, para assets)
- **Cuenta Brevo** (para emails)

## 🛠️ Instalación Completa

### 1. **Clonar y Configurar**
\`\`\`bash
# Clonar el repositorio
git clone <repository-url>
cd inventory-system

# Instalar dependencias
composer install

# Configurar entorno
cp .env.example .env
php artisan key:generate
\`\`\`

### 2. **Configurar Base de Datos**
\`\`\`env
# Editar .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_system
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
\`\`\`

### 3. **Configurar Email (Brevo)**
\`\`\`env
# Configuración de Brevo en .env
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@dominio.com
MAIL_PASSWORD=tu_smtp_key_brevo
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@dominio.com
MAIL_FROM_NAME="Sistema Inventario"

# Configuración adicional
BREVO_API_KEY=tu_api_key_brevo
BREVO_SENDER_EMAIL=tu_email@dominio.com
BREVO_SENDER_NAME="Sistema Inventario"
\`\`\`

### 4. **Configurar Aplicación**
\`\`\`bash
# Ejecutar migraciones
php artisan migrate

# Poblar con datos de ejemplo
php artisan db:seed

# Configurar sistema automáticamente
php artisan setup:system

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan view:clear
\`\`\`

### 5. **Iniciar Aplicación**
\`\`\`bash
# Servidor de desarrollo
php artisan serve

# La aplicación estará en: http://localhost:8000
\`\`\`

## 👤 Usuarios de Prueba

Después de ejecutar los seeders, tendrás estos usuarios disponibles:

\`\`\`
📧 admin@inventory.com
🔑 password
👤 Administrador

📧 manager@inventory.com  
🔑 password
👤 Gerente

📧 user@inventory.com
🔑 password
👤 Usuario
\`\`\`

## 🎯 Funcionalidades Detalladas

### **Dashboard**
- 📊 Total de productos y valor del inventario
- ⚠️ Alertas de productos con stock bajo
- 📈 Movimientos recientes de stock
- 🏷️ Estadísticas por categorías
- 🚚 Información de proveedores

### **Productos**
- ➕ Crear productos con toda la información
- ✏️ Editar detalles y precios
- 👁️ Ver información completa del producto
- 📦 Ajustar stock con modal interactivo
- 🔍 Buscar y filtrar productos
- ⚠️ Alertas automáticas de stock bajo

### **Control de Stock**
- 📥 **Entrada**: Compras, devoluciones de clientes
- 📤 **Salida**: Ventas, devoluciones a proveedores
- ⚖️ **Ajuste**: Correcciones de inventario
- 📋 Historial completo de movimientos
- 🔔 Notificaciones automáticas por email

### **Categorías**
- 🗂️ Organizar productos por categorías
- 📊 Ver estadísticas por categoría
- ✏️ Gestión completa CRUD

### **Proveedores**
- 🏢 Información completa de contacto
- 📞 Teléfonos, emails, direcciones
- 🛍️ Productos asociados a cada proveedor
- 📊 Estadísticas de compras

### **Sistema de Emails**
- 📧 **Bienvenida**: Email automático al registrarse
- ⚠️ **Stock Bajo**: Alertas cuando el stock es crítico
- 📦 **Movimientos**: Notificaciones de cambios importantes
- ✅ **Verificación**: Email de verificación obligatorio
- 🔄 **Recuperación**: Reset de contraseñas

## 🔧 Comandos Artisan Personalizados

\`\`\`bash
# Verificar productos con stock bajo
php artisan stock:check-low

# Probar conexión con Brevo
php artisan brevo:test

# Configurar sistema completo
php artisan setup:system

# Enviar email de prueba
php artisan email:test tu_email@dominio.com
\`\`\`

## 📱 Capturas de Funcionalidades

El sistema incluye:
- 🏠 **Dashboard** con métricas en tiempo real
- 📦 **Lista de productos** con filtros avanzados
- ➕ **Formularios** de creación y edición intuitivos
- ⚠️ **Alertas visuales** para stock bajo
- 📱 **Diseño responsive** para móviles y tablets
- 🔔 **Notificaciones** en tiempo real
- 📧 **Emails** con plantillas profesionales

## 🎨 Tecnologías Utilizadas

### **Backend**
- **Laravel 9** - Framework PHP
- **MySQL** - Base de datos
- **Eloquent ORM** - Manejo de datos
- **Laravel Mail** - Sistema de emails
- **Brevo API** - Servicio de email

### **Frontend**
- **Blade Templates** - Motor de plantillas
- **Tailwind CSS** - Framework CSS
- **Font Awesome** - Iconos
- **JavaScript Vanilla** - Interactividad
- **Alpine.js** - Componentes reactivos

### **Herramientas**
- **Composer** - Gestor de dependencias PHP
- **Artisan** - CLI de Laravel
- **Migrations** - Control de versiones DB
- **Seeders** - Datos de prueba

## 🔧 Personalización Avanzada

### **Agregar Nuevos Campos a Productos**
\`\`\`bash
# 1. Crear migración
php artisan make:migration add_new_field_to_products_table

# 2. Editar migración
# 3. Ejecutar migración
php artisan migrate

# 4. Actualizar modelo Product
# 5. Modificar formularios en vistas
# 6. Actualizar validaciones en controlador
\`\`\`

### **Personalizar Alertas de Stock**
\`\`\`php
// En app/Models/Product.php
public function isLowStock()
{
    return $this->stock <= $this->min_stock; // Personalizar lógica
}
\`\`\`

### **Agregar Nuevas Notificaciones**
\`\`\`bash
# Crear notificación
php artisan make:notification NuevaNoficacion

# Crear plantilla de email
# resources/views/emails/nueva-notificacion.blade.php
\`\`\`

## 📈 Próximas Funcionalidades

- [ ] 🛒 **Módulo de Ventas** completo
- [ ] 📄 **Reportes en PDF** exportables
- [ ] 📱 **Códigos QR** para productos
- [ ] 🏪 **Múltiples ubicaciones/almacenes**
- [ ] 🔌 **API REST** completa
- [ ] 📊 **Dashboard avanzado** con gráficos
- [ ] 🔔 **Notificaciones push** en tiempo real
- [ ] 💰 **Control de costos** y rentabilidad
- [ ] 📱 **App móvil** nativa
- [ ] 🤖 **Automatización** de procesos

## 🚀 Despliegue en Producción

### **Preparar para Producción**
\`\`\`bash
# Optimizar aplicación
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configurar .env para producción
APP_ENV=production
APP_DEBUG=false
\`\`\`

### **Configurar Servidor Web**
- Configurar Apache/Nginx
- Configurar SSL/HTTPS
- Configurar cron jobs para comandos
- Configurar backups automáticos

## 🤝 Contribuir al Proyecto

1. **Fork** el proyecto
2. Crear rama para nueva funcionalidad:
   \`\`\`bash
   git checkout -b feature/nueva-funcionalidad
   \`\`\`
3. **Commit** los cambios:
   \`\`\`bash
   git commit -am 'Agregar nueva funcionalidad'
   \`\`\`
4. **Push** a la rama:
   \`\`\`bash
   git push origin feature/nueva-funcionalidad
   \`\`\`
5. Abrir **Pull Request**

## 📞 Soporte y Ayuda

### **Problemas Comunes**
- **Error de email**: Verificar configuración de Brevo
- **Error de base de datos**: Verificar credenciales en .env
- **Error de permisos**: Configurar permisos de storage y bootstrap/cache

### **Obtener Ayuda**
- 🐛 **Issues**: Reportar bugs en GitHub
- 💬 **Discusiones**: Preguntas generales
- 📧 **Email**: Contacto directo con desarrolladores
- 📚 **Documentación**: Wiki del proyecto

## 📄 Licencia

Este proyecto está bajo la **Licencia MIT**. Ver el archivo `LICENSE` para más detalles.

## 🙏 Agradecimientos

- **Laravel Team** - Por el excelente framework
- **Tailwind CSS** - Por el sistema de diseño
- **Brevo** - Por el servicio de email confiable
- **Comunidad PHP** - Por las librerías y herramientas

---

## 🎉 **¡Gracias por usar nuestro Sistema de Inventario!**

**Desarrollado con ❤️ para pequeñas y medianas empresas**

### 📊 **Estadísticas del Proyecto**
- ✅ **100+** archivos de código
- 🗃️ **15+** tablas de base de datos  
- 📧 **6** plantillas de email
- 🎨 **20+** vistas Blade
- 🔧 **10+** comandos Artisan personalizados

**¿Te gusta el proyecto? ⭐ ¡Dale una estrella en GitHub!**
