# MiniVend — Sistema de Gestión de Ventas e Inventario

MiniVend es un sistema web de Punto de Venta (POS) y gestión de inventario construido con PHP, MySQL y el patrón arquitectónico MVC. Proporciona a pequeñas y medianas empresas una solución completa y estructurada para registrar productos, procesar ventas, gestionar clientes y supervisar la actividad de las cajas — todo desde una interfaz moderna en el navegador.

---

## El problema que resuelve

Muchos negocios pequeños — tiendas de abarrotes, tiendas de conveniencia, pequeños almacenes — todavía administran sus ventas e inventario mediante cuadernos en papel, hojas de cálculo o software de escritorio desactualizado. Estos métodos comparten un conjunto de problemas críticos que afectan directamente la rentabilidad y la seguridad del negocio:

- **Inventario desorganizado y poco confiable**: El stock se registra manualmente y casi siempre es inexacto. Los productos se agotan sin previo aviso o se acumula mercancía en exceso porque no existe un conteo confiable en tiempo real.
- **Sin historial de ventas**: Sin un registro centralizado, el propietario no puede responder preguntas básicas como "¿cuánto vendí esta semana?" o "¿qué producto se mueve más?". Las decisiones de compra se toman a ciegas.
- **Datos inseguros y vulnerables**: Las hojas de cálculo se comparten por USB o correo electrónico, no tienen control de acceso, y cualquier persona puede modificarlas o eliminarlas accidentalmente. No existe rastro de auditoría.
- **Herramientas obsoletas y limitadas**: El software de escritorio antiguo generalmente está atado a una sola máquina, requiere licencias de pago, no puede usarse desde múltiples puestos de trabajo y no genera reportes ni facturas digitales.
- **Sin seguimiento de clientes**: Las ventas son anónimas. No hay forma de identificar clientes frecuentes, emitir facturas a nombre de una persona específica ni resolver disputas con evidencia.
- **Múltiples cajas sin control**: Cuando hay más de un cajero, no existe forma de saber cuánto efectivo debe tener cada caja al final del día ni quién realizó cada venta.

MiniVend fue construido específicamente para resolver estos problemas. Reemplaza el caos del registro manual con un sistema basado en navegador, estructurado y seguro, que múltiples cajeros pueden usar simultáneamente, que mantiene el inventario actualizado en tiempo real, y que genera facturas y tickets profesionales en formato PDF de forma instantánea.

---

## Funcionalidades

- **Dashboard** — Vista general con estadísticas del sistema al acceder.
- **Gestión de productos** — Registra productos con código de barras, nombre, precio de compra y venta, stock, marca, modelo, tipo de unidad, categoría y foto. CRUD completo con validación de datos.
- **Gestión de categorías** — Organiza productos en categorías con ubicación opcional en bodega. Protege la eliminación si hay productos asociados.
- **Gestión de clientes** — Registra clientes con tipo de documento, número, nombre, dirección, ciudad, provincia, teléfono y correo. Los clientes se vinculan a ventas para la generación de facturas.
- **Punto de Venta (POS)** — Flujo de venta por carrito: escanea o busca productos por código, agrega un cliente, ingresa el monto pagado y el sistema calcula el cambio, descuenta el stock y registra la transacción de forma atómica.
- **Historial de ventas** — Lista paginada de todas las ventas completadas. Cada venta puede visualizarse en detalle, imprimirse como factura formal (PDF) o como ticket térmico (PDF).
- **Gestión de cajas** — Se pueden configurar múltiples cajas registradoras. Cada una registra su propio saldo de efectivo, que se actualiza automáticamente con cada venta.
- **Gestión de usuarios** — Crea usuarios del sistema y asígnalos a una caja. La eliminación o actualización de usuarios requiere verificación de credenciales de administrador. Soporta foto de perfil.
- **Configuración de empresa** — Configura el nombre del negocio, teléfono, correo y dirección que aparecen en facturas y tickets.
- **Búsqueda global** — Todas las vistas (productos, clientes, usuarios, ventas, cajas, categorías) incluyen búsqueda por texto con persistencia en sesión.
- **Generación de PDF** — Facturas y tickets térmicos se generan en el servidor usando FPDF, sin ningún servicio externo.
- **Sesiones seguras** — Todas las rutas están protegidas. Las solicitudes no autenticadas se redirigen al login. Las contraseñas se almacenan con hash bcrypt.

---

## Stack tecnológico

| Capa | Tecnología |
|---|---|
| Backend | PHP |
| Arquitectura | MVC (Modelo-Vista-Controlador) |
| Base de datos | MySQL / MariaDB |
| Frontend | Bulma CSS, Remix Icons, Inter (Google Fonts) |
| AJAX | Vanilla JS + Fetch API |
| PDF | Librería FPDF |
| Servidor | Apache (con mod_rewrite) |

---

## Estructura del proyecto

```
MiniVend/
├── config/
│   ├── app.php          # URL, nombre de la app, moneda, zona horaria
│   └── server.php       # Credenciales de la base de datos
├── app/
│   ├── models/          # mainModel (abstracción DB), viewsModel (enrutamiento)
│   ├── controllers/     # Un controlador por módulo
│   ├── ajax/            # Puntos de entrada AJAX llamados desde el frontend
│   ├── views/
│   │   ├── content/     # Un archivo de vista por página
│   │   └── inc/         # Parciales compartidos: navbar, head, footer, scripts
│   └── pdf/             # Generadores de facturas y tickets (FPDF)
├── DB/
│   └── ventas.sql       # Esquema completo de base de datos + datos iniciales
├── index.php            # Controlador frontal / router
├── autoload.php         # Autocargador de clases
└── .htaccess            # Reglas de reescritura de URL
```

---

## Requisitos

- Apache 2.4+ con `mod_rewrite` habilitado y `AllowOverride All`
- PHP 8.0 o superior
- MySQL 5.7+ o MariaDB 10+
- Un stack de servidor local como XAMPP, Laragon o WAMP (para desarrollo local)

---

## Instalación

### 1. Clonar o descargar el proyecto

Coloca la carpeta `MiniVend` dentro del directorio raíz de tu servidor web:

```
# XAMPP (Windows)
C:\xampp\htdocs\MiniVend\

# Laragon
C:\laragon\www\MiniVend\
```

### 2. Crear la base de datos

1. Abre phpMyAdmin en `http://localhost/phpmyadmin`
2. Crea una nueva base de datos — puedes llamarla como prefieras (por ejemplo, `minivend`)
3. Selecciona la base de datos, ve a la pestaña **Importar** e importa el archivo en:

```
MiniVend/DB/ventas.sql
```

### 3. Configurar la conexión a la base de datos

Abre [config/server.php](config/server.php) y ajusta tus credenciales:

```php
const DB_SERVER = "localhost";
const DB_NAME   = "minivend";   // el nombre que elegiste en el paso 2
const DB_USER   = "root";
const DB_PASS   = "";           // vacío por defecto en XAMPP
```

### 4. Configurar la URL de la aplicación

Abre [config/app.php](config/app.php) y establece la URL correcta:

```php
const APP_URL  = "http://localhost/MiniVend/";
const APP_NAME = "MiniVend";
```

Si despliegas en un servidor remoto, actualiza `APP_URL` con tu dominio:

```php
const APP_URL = "https://tudominio.com/MiniVend/";
```

### 5. Verificar la configuración de Apache

Asegúrate de que `mod_rewrite` esté habilitado y que `AllowOverride All` esté configurado para tu directorio htdocs en `httpd.conf`. En XAMPP esto viene habilitado por defecto.

### 6. Abrir la aplicación

Navega a:

```
http://localhost/MiniVend/
```

### 7. Iniciar sesión con la cuenta predeterminada

| Campo | Valor |
|---|---|
| Usuario | `Administrador` |
| Contraseña | `Administrador` |

Cambia la contraseña tras tu primer inicio de sesión.

---

## Primeros pasos después de la instalación

1. Ve a **Empresa** e ingresa el nombre, dirección y datos de contacto de tu negocio — esta información aparece en cada factura.
2. Ve a **Cajas** y crea al menos una caja registradora con saldo inicial en efectivo.
3. Ve a **Categorías** y crea las categorías de tus productos.
4. Ve a **Productos** y comienza a registrar tu inventario.
5. Ve a **Clientes** y registra a tus clientes, o usa la entrada predeterminada "Consumidor Final" para ventas al público.
6. Crea **Usuarios** adicionales y asígnalos a una caja si varias personas usarán el sistema.
7. Ve a **Nueva Venta** y procesa tu primera transacción.

---

## Credenciales predeterminadas

```
Usuario:    Administrador
Contraseña: Administrador
```

Estas credenciales están incluidas en la base de datos al importarla. Cámbialas inmediatamente después de la configuración.

---

## Licencia

Este proyecto es de código abierto y está disponible bajo la [Licencia MIT](LICENSE).

---

## Autor

**Johan Alejandro Campo Pabón**

Desarrollador de Software con enfoque en Backend. Ingeniería Electrónica — Universidad del Magdalena, Colombia.

Más de 1 año de experiencia construyendo aplicaciones web y soluciones empresariales con **.NET, Node.js y PHP**, diseñando APIs REST y lógica de negocio sobre bases de datos SQL y NoSQL.

```text
Backend      →  C# · .NET · ASP.NET Core · Node.js · PHP
Bases de datos → SQL Server · MySQL · MongoDB · EF Core · Prisma ORM
Frontend     →  React · Next.js · TypeScript · Tailwind CSS
```

| Contacto | Enlace |
|---|---|
| Email | johancampo12@gmail.com |
| LinkedIn | [linkedin.com/in/johan-alejandro-campo-pabon-6b1a422b8](https://www.linkedin.com/in/johan-alejandro-campo-pabon-6b1a422b8/) |
| Portfolio | [johancampo.dev](https://johancampo.dev) |
| GitHub | [github.com/Johan-Campo](https://github.com/Johan-Campo) |
