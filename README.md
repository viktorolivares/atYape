# Proyecto atYape

Este es el repositorio del proyecto **atYape**, el cual tiene como objetivo desarrollar una aplicación móvil que se integre con la aplicación Yape y sea capaz de recibir notificaciones en tiempo real de las transacciones. Además, se busca implementar una base de datos para almacenar la información de las transacciones recibidas junto con su estado de validación. La interfaz de usuario se ha diseñado para ser amigable y fácil de usar, permitiendo a los usuarios validar y actualizar la información de las transacciones.

## Estructura del Proyecto

El proyecto está organizado de la siguiente manera:

- `app/`: Contiene la lógica de la aplicación.
  - `Console/`: Archivos relacionados con comandos de consola.
  - `Exceptions/`: Manejo de excepciones.
  - `Http/`: Controladores y middleware.
  - `Models/`: Modelos de base de datos.
  - `Providers/`: Proveedores de servicios.
- `bootstrap/`: Configuraciones iniciales y optimización de carga.
- `config/`: Archivos de configuración de la aplicación.
- `database/`: Migraciones y semillas para la base de datos.
- `resources/`: Archivos de recursos como CSS, JavaScript y vistas.
- `routes/`: Definiciones de rutas de la aplicación.
- `storage/`: Almacenamiento de archivos y registros.
- `tests/`: Pruebas unitarias y de características.
- Otros archivos importantes:
  - `.env`: Archivo de configuración de variables de entorno.
  - `composer.json` y `composer.lock`: Configuración y dependencias de Composer.
  - `package.json` y `package-lock.json`: Configuración y dependencias de npm.
  - `phpunit.xml`: Configuración para las pruebas unitarias.

## Inicio Rápido

1. Clona este repositorio en tu entorno local.
2. Configura las variables de entorno en el archivo `.env`.
3. Ejecuta `composer install` para instalar las dependencias de PHP.
4. Ejecuta `npm install` para instalar las dependencias de JavaScript.
5. Ejecuta `php artisan key:generate` para generar la clave de la aplicación.
6. Ejecuta `php artisan migrate` para aplicar las migraciones a la base de datos.
7. Ejecuta `npm run dev` para compilar los activos de JavaScript y CSS.
8. Ejecuta `php artisan serve` para iniciar el servidor de desarrollo.

## Contribución

Si deseas contribuir al proyecto, sigue estos pasos:

1. Haz un fork de este repositorio.
2. Crea una rama con tu nueva función: `git checkout -b nueva-funcion`.
3. Realiza tus cambios y commitea: `git commit -m "Agregada nueva función"`.
4. Sube tus cambios a tu repositorio: `git push origin nueva-funcion`.
5. Abre una solicitud de extracción en este repositorio.

¡Gracias por tu contribución!
