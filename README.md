___________________________________________________________________________________

-QUE FUNCIONE TAILWING ALPINE Y LIVEWIRE Y SE ACTUALICEN LAS VISTAS

npm run dev
___________________________________________________________________________________

-HACER CAMBIOS Y SUBIRLOS

git add .                 # Añade los archivos modificados
git commit -m "Mensaje"   # Guarda un punto de control
git push origin main      # Lo sube a GitHub
___________________________________________________________________________________

-BORRAR TODAS LAS MIGRACIONES Y CREARLAS DE NUEVO Y EJECTUAR LOS SEEDERS.

php artisan migrate:fresh --seed
_________________________________________________________________________________

-CREAR UNA MIGRACIÓN Y CON MODELO

//sin modelo
php artisan make:migration create_nombre_de_la_tabla_table

//con modelo
php artisan make:model NombreDelModelo -m

//con modelo y factory
php artisan make:model NombreDelModelo -mf
___________________________________________________________________________________

-CREAR FACTORY Y SEEDER

//solo un factory
php artisan make:factory NombreDelModeloFactory

// crear seeder
php artisan make:seeder NombreDelModeloSeeder
___________________________________________________________________________________

-SI EMPIEZAS DESDE 0

(dentro de htdocs)

git clone https://github.com/Ferdilicius/bancal.git

cd bancal

Copia .env.example .env edita el tu archivo .env para ti mismo.

composer install
npm install

php artisan key:generate
___________________________________________________________________________________

Cuando se realice un commit, se añadirá, al principio, una palabra determinada para conocer, a simple vista, de qué se trata dicho commit:

feat: para nuevas funcionalidades
fix: para correcciones de errores
docs: para modificaciones en la documentación
style: para modificaciones en el código de estilo
refactor: para refactorizaciones
chore: para cambios en la organización de las carpetas

EL CARITO SE GUARDA SOLAMENTE EN LA BASE DE DATOS CUANDO ESTE LOGGEADO
SI NO LO ESTÁ SE GUARDARÁ EN LA CACHE O MEMORIA DEL NAVEGADOR (ANGULAR)
