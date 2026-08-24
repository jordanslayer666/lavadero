#!/bin/bash

echo "Iniciando script de preparación del servidor..."

# Asegurar que el directorio de la base de datos existe
mkdir -p /var/www/html/database

# Crear el archivo SQLite de la base de datos si no existe
touch /var/www/html/database/database.sqlite

# Dar permisos completos para que Apache pueda leer y escribir en la base de datos
chmod 777 /var/www/html/database/database.sqlite
chmod 777 /var/www/html/database

# Generar la llave de la aplicación por seguridad (en caso de no existir .env)
php artisan key:generate --force

# Ejecutar las migraciones y sembrar (seed) la base de datos con los usuarios de prueba
# Se usa --force para forzar la ejecución en el entorno de producción de Render
php artisan migrate:fresh --seed --force

echo "Base de datos configurada. Iniciando Apache..."

# Iniciar Apache en el contenedor de forma persistente
apache2-foreground
