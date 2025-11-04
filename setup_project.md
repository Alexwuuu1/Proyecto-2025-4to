# Guía para Clonar y Ejecutar el Proyecto Laravel "Proyecto-2025-4to" en Otra Máquina

Esta guía proporciona los pasos detallados para clonar el repositorio desde GitHub y configurar el proyecto Laravel en una nueva máquina. El proyecto requiere XAMPP (para Apache y MySQL), PHP, Composer, Node.js y npm.

## Prerrequisitos
- Instalar XAMPP (incluye Apache, MySQL, PHP): Descárgalo desde https://www.apachefriends.org/es/index.html
- Instalar Composer: https://getcomposer.org/download/
- Instalar Node.js y npm: https://nodejs.org/
- Instalar Git: https://git-scm.com/
- Asegurarse de que PHP esté en el PATH del sistema (desde XAMPP).

## Pasos para Configurar el Proyecto

### 1. Clonar el Repositorio
Abre una terminal (cmd o PowerShell) en el directorio donde quieres clonar el proyecto (ej. C:\xampp\htdocs\).

```bash
git clone https://github.com/Alexwuuu1/Proyecto-2025-4to.git
cd Proyecto-2025-4to
```

### 2. Instalar Dependencias de PHP (Composer)
Ejecuta el siguiente comando para instalar las dependencias de Laravel:

```bash
composer install
```

### 3. Configurar el Archivo .env
Copia el archivo de ejemplo y edítalo con tus configuraciones locales:

```bash
copy .env.example .env
```

Edita `.env` con un editor de texto:
- Configura la base de datos: DB_CONNECTION=mysql, DB_HOST=127.0.0.1, DB_PORT=3306, DB_DATABASE=voluntariado_db, DB_USERNAME=root, DB_PASSWORD= (deja vacío si no hay contraseña).
- Ajusta APP_URL=http://localhost:8000 o similar.

Genera la clave de aplicación:

```bash
php artisan key:generate
```

### 4. Configurar la Base de Datos
- Inicia XAMPP y enciende Apache y MySQL.
- Crea la base de datos `voluntariado_db` en phpMyAdmin (http://localhost/phpmyadmin).
- Importa el dump de la base de datos:

```bash
"C:\xampp\mysql\bin\mysql.exe" -u root -p voluntariado_db < "basedelabase/voluntariado_db (1).sql"
```

Si hay contraseña en MySQL, agrégala después de -p.

Ejecuta las migraciones de Laravel (opcional, ya que el dump incluye datos):

```bash
php artisan migrate --force
```

### 5. Instalar Dependencias de Frontend (npm)
Instala las dependencias de Node.js:

```bash
npm install
```

Compila los assets:

```bash
npm run build
```

### 6. Ejecutar el Proyecto
Inicia el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

En otra terminal, inicia Vite para el frontend:

```bash
npm run dev
```

El proyecto estará disponible en http://localhost:8000 (o el puerto que indique artisan serve).

## Notas Adicionales
- Si encuentras errores de permisos, ejecuta la terminal como administrador.
- Para desarrollo continuo, usa `npm run dev` en una terminal separada para hot reload.
- El proyecto usa Tailwind CSS y Laravel Breeze para autenticación.
- Si hay problemas con la base de datos, verifica que MySQL esté corriendo y las credenciales en .env sean correctas.

## Script Automatizado (Opcional)
Si quieres automatizar, crea un archivo `setup.bat` con el siguiente contenido y ejecútalo:

```batch
@echo off
echo Clonando repositorio...
git clone https://github.com/Alexwuuu1/Proyecto-2025-4to.git
cd Proyecto-2025-4to

echo Instalando dependencias de Composer...
composer install

echo Copiando .env...
copy .env.example .env

echo Generando clave...
php artisan key:generate

echo Importando base de datos...
"C:\xampp\mysql\bin\mysql.exe" -u root -p voluntariado_db < "basedelabase/voluntariado_db (1).sql"

echo Instalando dependencias de npm...
npm install

echo Compilando assets...
npm run build

echo Ejecutando migraciones...
php artisan migrate --force

echo Iniciando servidor...
start cmd /k "php artisan serve"
start cmd /k "npm run dev"

echo Proyecto listo. Accede a http://localhost:8000
pause
```

Ejecuta `setup.bat` desde el directorio deseado (no dentro del proyecto ya clonado).
