# merla

## Descargar el proyecto

1. Clonar  repositorio
**git clone {link del repo sin las llaves}**
2. Crear base de datos con nombre **usuarios** con esta codificacion  utf8_general_ci
3. Instalar node.js y correr los comandos dentro de la carpeta del proyecto
**npm install && run dev**
4. instalar composer
**composer update**
estos pasos seran cuando tengamos los seeder listos y las migraciones
5. **php artisan storage:link**
6. **php artisan migrate:fresh --seed**

---
## Settear ambiente local
1. en el .env que hay de ejemplo tienen que modificar lo siguiente normalmente el app solo vendra (quitar al .envexample la palabra "example") 
**APP_URL=localhost:** pero tienen que ponerlo asi **APP_URL=http://localhost:8000** y agregar el siguiente **ASSET_URL=http://localhost:8000** esto es con el fin de que tome en cuenta los estilos ya que usan laravel mix y modificar la conexion de la base de datos en caso que el puerto este ocupado, o usen alguna otra.
---
## Correr el proyecto de manera local
php artisan serve

---
## Subir cambios al repositorio de github
Para subir cambios se debe crear un branch con tu nombre y trabajar siempre en ella
1. Asegurate de que estas en tu branch por medio de: git status
2. Cambiar de branch: git checkout {Nombre de tu branch sin las llaves}
3. git add . (Para agregar todos los archivos cambiados) o usa git add {nombre de tu archivo sin las llaves} para agregar uno por uno
4. git commit "aqui va tu comentario de que hiciste"
5. git push

Si te sale el error de que no sabe quien eres o de que te tienes que identificar usa:
1. git config user.name "Tu nombre de usuario"
2. git config user.email "Tu email"

---

## Limpiar el cache del proyecto en caso de ser necesario
php artisan cache:clear

## Mantener tu branch al dia con main cuando sea necesario
git merge main desde tu branch
git push

## Proyecto realizado por

- Samuel Esparza
- Axel Vazquez
- Uriel Rodríguez