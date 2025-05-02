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
___________________________________________________________________________________

-CREAR UNA MIGRACIÓN

php artisan make:migration create_nombre_de_la_tabla_table
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