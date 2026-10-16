# Laboratorio 4: Lift and Shift con Docker

## 1. Análisis del proyecto

- **Lenguaje:** PHP.
- **Servidor y puerto:** Apache dentro de la imagen `php:8.2-apache`, escuchando en el puerto 80 del contenedor. Docker Compose publica la aplicación en `http://localhost:8080`.
- **Patrón:** MVC (Modelo-Vista-Controlador). `SiteController` selecciona vistas y procesa peticiones, `ContactoModel` accede a MySQL y los archivos de `views/` presentan el contenido.
- **Enrutamiento:** `.htaccess` utiliza `mod_rewrite` para enviar las rutas a `index.php`.

## 2. Transformación realizada

1. Se cambió la conexión PDO para utilizar `db-mysql`, el nombre del servicio MySQL de Compose. Los valores también pueden configurarse mediante variables de entorno.
2. Se creó un `Dockerfile` con PHP 8.2 y Apache, las extensiones PDO para MySQL y el módulo `mod_rewrite`.
3. Se agregó `docker-compose.yml` con los servicios `web-app`, `db-mysql` y `phpmyadmin`. La aplicación y phpMyAdmin esperan a que MySQL esté saludable antes de arrancar.
4. El volumen nombrado `datos-persistentes` conserva la base de datos al detener o recrear los contenedores.
5. `database/init.sql` crea la tabla `contactos` con `nombre`, `correo` y `comentario`. MySQL ejecuta este script automáticamente al inicializar por primera vez un volumen de datos vacío.
6. El controlador valida los campos y el formato del correo. El modelo guarda los tres datos con una consulta preparada.
7. Se agregó la página **Mis gustos personales** y se renovó el estilo visual para el sitio completo.

## 3. Ejecución y comprobación

Desde la carpeta raíz del proyecto:

```powershell
docker compose up --build
```

- Aplicación web: <http://localhost:8080>
- Página personal: <http://localhost:8080/gustos>
- Formulario: <http://localhost:8080/contacto>
- phpMyAdmin: <http://localhost:8085> (usuario `root`, contraseña `clave_secreta_nube`)

Enviar el formulario con nombre, correo y comentario. Luego, en phpMyAdmin, seleccionar `db_proyecto_mvc`, abrir `contactos` y consultar la tabla para comprobar que los tres campos quedaron guardados. Para comprobar persistencia, detener y volver a iniciar los servicios sin eliminar el volumen.

### Si ya existe una base de datos o tabla anterior

Los scripts en `/docker-entrypoint-initdb.d` solo se ejecutan cuando MySQL inicializa un directorio de datos vacío. En una instalación anterior, abrir phpMyAdmin, seleccionar `db_proyecto_mvc` y ejecutar:

```sql
ALTER TABLE contactos
    ADD COLUMN correo VARCHAR(254) NOT NULL DEFAULT '',
    ADD COLUMN comentario TEXT NOT NULL;
```

No se debe borrar el volumen persistente para aplicar la actualización, porque hacerlo eliminaría los datos existentes.

## 4. Evidencias pendientes de captura

Después de arrancar los servicios, incluir en la entrega capturas reales de:

1. `http://localhost:8080/gustos`, mostrando la sección personal y el diseño actualizado.
2. El mensaje que aparece tras enviar el formulario.
3. phpMyAdmin con los registros de `contactos`, donde se vean `correo` y `comentario`.

## 5. Conclusiones

1. Lift and Shift permite empaquetar una aplicación tradicional junto con sus dependencias y servicios, reduciendo diferencias entre el entorno local y uno preparado para la nube sin reescribir de inmediato su arquitectura.
2. Docker Compose facilita reproducir el entorno completo y la red entre contenedores; usar el nombre del servicio como host de la base de datos y un volumen persistente son esenciales para que la aplicación funcione y conserve la información.
3. La modernización también requiere atender aspectos funcionales: validar datos, guardar con consultas preparadas y comprobar el recorrido completo desde el formulario hasta MySQL.

## 6. Publicación del repositorio

Después de revisar las capturas y confirmar el funcionamiento, publicar la carpeta `proyectoWebMVC` en un repositorio GitHub propio y agregar aquí la URL del repositorio.
