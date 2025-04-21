# 📋 Sistema de Tickets
Este proyecto es el backend de un Sistema de **Tickets** hecho en **Laravel**. Se recomienda descargar el [Frontend]() para una mejor experiencia.
## ✨ Características del sistema
- Registro de usuarios
- Inicio de sesión y autenticación con JWT
- Roles de usuario (Administrador, Soporte y Usuario)
- Creación de Tickets
- Gestión de tickets y usuarios

## 🧪 Tecnologías usadas
- Laravel
- Docker
- MySQL

## 📦 Dependencias
```bash
# Instalar composer
composer install
```

## ⚙️ Instalación
```bash
# Clonación del proyecto
git clone
cd repo

# Creación del archivo de entorno
cp .env.example .env

# Generar keys
php artisan key:generate
php artisan jwt:secret

# Ejecutar migraciones y cargar datos de prueba
php artisan migrate
php artisan migrate --seed

# Iniciar aplicación
php artisan serve
```

## 👥 Usuarios de prueba

| Rol | Correo   | Contraseña  |
|:----------|:--------:|---------:|
| Admin | admin@ticket.cl | admin123  |
| Soporte | soporte@ticket.cl | soporte123  |
| Cliente | juan@gmail.com | cliente123  |

## 🔐 Roles y permisos

| Nombre | Permisos   |
|:----------|:--------:|
| Administrador    | Gestión tickets y usuarios |
| Soporte    | Responde y gestiona los tickets  |
| Usuario    | Creación de tickets y navegación básica|

## 🔌 Endpoints

| Método | Ruta   | Descripción  |
|:----------|:--------:|---------:|
| GET | WIP | WIP  |
| GET | WIP | WIP  |
| GET | WIP | WIP  |
| GET | WIP | WIP  |
| POST | WIP | Registro de usuario  |
| POST | WIP | Iniciar sesión  |
| POST | WIP | Crear ticket  |
| POST | WIP | Responder ticket  |
