___________________________________________________________________________________

-QUE FUNCIONE TAILWING ALPINE Y LIVEWIRE Y SE ACTUALICEN LAS VISTAS

npm run dev
___________________________________________________________________________________

-PARA DEPENDENCIAS

composer install
npm install
___________________________________________________________________________________

-HACER CAMBIOS Y SUBIRLOS

git add .                 # Añade los archivos modificados
git commit -m "Mensaje"   # Guarda un punto de control
git push origin main      # Lo sube a GitHub
___________________________________________________________________________________

-GENERAR APP KEY (una vez)

php artisan key:generate
___________________________________________________________________________________

-BORRAR TODAS LAS MIGRACIONES Y CREARLAS DE NUEVO Y EJECTUAR LOS SEEDERS.

php artisan migrate:fresh --seed
___________________________________________________________________________________
