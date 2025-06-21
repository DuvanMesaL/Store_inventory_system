# Sistema de Inventario Laravel

Un sistema completo de gestión de inventario para tiendas locales desarrollado con Laravel.

## 🚀 Características

- **Dashboard Completo**: Vista general con estadísticas y métricas importantes
- **Gestión de Productos**: CRUD completo con control de stock
- **Categorías y Proveedores**: Organización y clasificación de productos
- **Control de Stock**: Alertas de stock bajo y movimientos de inventario
- **Interfaz Responsive**: Diseño adaptable para móviles y escritorio
- **Reportes**: Estadísticas y análisis del inventario

## 📋 Requisitos

- PHP >= 8.0
- Composer
- MySQL/MariaDB
- Node.js y NPM (opcional, para assets)

## 🛠️ Instalación

1. **Clonar el repositorio**
\`\`\`bash
git clone <repository-url>
cd inventory-system
\`\`\`

2. **Instalar dependencias**
\`\`\`bash
composer install
\`\`\`

3. **Configurar el archivo de entorno**
\`\`\`bash
cp .env.example .env
\`\`\`

4. **Generar la clave de aplicación**
\`\`\`bash
php artisan key:generate
\`\`\`

5. **Configurar la base de datos**
Edita el archivo `.env` con tus credenciales de base de datos:
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_system
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
\`\`\`

6. **Ejecutar las migraciones**
\`\`\`bash
php artisan migrate
\`\`\`

7. **Poblar la base de datos con datos de ejemplo**
\`\`\`bash
php artisan db:seed
\`\`\`

8. **Iniciar el servidor de desarrollo**
\`\`\`bash
php artisan serve
\`\`\`

La aplicación estará disponible en `http://localhost:8000`

## 📊 Funcionalidades Principales

### Dashboard
- Estadísticas generales del inventario
- Productos con stock bajo
- Movimientos recientes de stock
- Valor total del inventario

### Productos
- Crear, editar y eliminar productos
- Control de stock con alertas automáticas
- Gestión de precios y márgenes
- Códigos de barras y SKU
- Filtros y búsqueda avanzada

### Categorías
- Organización de productos por categorías
- Estadísticas por categoría

### Proveedores
- Gestión completa de proveedores
- Información de contacto
- Productos por proveedor

### Control de Stock
- Movimientos de entrada, salida y ajustes
- Historial completo de movimientos
- Alertas automáticas de stock bajo

## 🎨 Tecnologías Utilizadas

- **Backend**: Laravel 9
- **Frontend**: Blade Templates + Tailwind CSS
- **Base de Datos**: MySQL
- **Iconos**: Font Awesome
- **Estilos**: Tailwind CSS

## 📱 Capturas de Pantalla

El sistema incluye:
- Dashboard con métricas importantes
- Lista de productos con filtros
- Formularios de creación y edición
- Alertas visuales para stock bajo
- Interfaz responsive para móviles

## 🔧 Personalización

### Agregar nuevos campos a productos
1. Crear una nueva migración
2. Actualizar el modelo `Product`
3. Modificar los formularios en las vistas
4. Actualizar las validaciones en el controlador

### Personalizar alertas de stock
Modifica el método `isLowStock()` en el modelo `Product` para cambiar la lógica de alertas.

## 📈 Próximas Funcionalidades

- [ ] Reportes en PDF
- [ ] Códigos QR para productos
- [ ] Sistema de ventas básico
- [ ] Múltiples ubicaciones/almacenes
- [ ] API REST
- [ ] Notificaciones por email

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu funcionalidad (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

Si tienes alguna pregunta o necesitas ayuda, puedes:
- Abrir un issue en GitHub
- Contactar al desarrollador

---

**¡Gracias por usar nuestro Sistema de Inventario!** 🎉
