<p align="center">
    <img height="100px" widht="100px" src="http://servicio.wasapping.com/img/logo.png">
</p>


## Sobre wasapping

Es una aplicación web que permite enviar mensajería a tu lista de contactos de forma rápida a través de Whatsapp:

## Instalación

1. Abrir terminal donde se quiere crear la carpeta del proyecto
2. Clonar repositorio de GitHub
```bash
git clone https://github.com/Jhomalex/sibs.git
cd sibs
```
3. Correr dependencias
```bash
composer install
composer dump-autoload
```
4. Crear una base de datos
5. Crear un archivo `.env` en base a `.env.example`
```bash
cp .env.example .env
```
6. Editar archivo `.env` con la base de datos que se acaba de crear
7. Generar la llave de la aplicación
```bash
php artisan key:generate
```
8. Correr seed
```bash
php artisan migrate:refresh --seed
```
9. Vínculo public/storage
```bash
php artisan storage:link
```

## Solución a errores comunes:

### Errores de Vue: 

#### - Error code ELIFECYCLE ####

1. Ejecutar en la consola: 
```npm cache clean --force```
2. Eliminar carpeta ```node_modules```
3. Eliminar archivo ```package-lock.json```
4. Ejecutar en la consola:
```npm install```