# 📋 Sistema de Tickets
Este proyecto es el backend de un Sistema de **Tickets** hecho en **Laravel**. Se recomienda descargar el [Frontend]() para una mejor experiencia.
## ✨ Características del sistema
- Registro de usuarios
- Inicio de sesión y autenticación con JWT
- Roles de usuario (Administrador, Soporte y Usuario)
- Creación de Tickets y la capacidad de responderles
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
| Administrador | Gestión de tickets y usuarios |
| Soporte | Responde y gestiona los tickets  |
| Usuario | Creación de tickets y navegación básica|

## 🔌 Endpoints

Puedes ver ejemplos de consumir los endpoints [aquí]()

### Usuarios
| Método | Ruta   | Descripción  | Requiere autenticación |
|:----------|:--------:|:---------:|:---------:|
| GET | /api/users | Retorna todos los usuarios  | ✅ |
| GET | /api/users/{id} | Retorna un usuario por su id | ✅ |
| POST | /api/register | Registro de usuario  | ❌ |
| POST | /api/login | Iniciar sesión  | ❌ |
| POST | /api/logout | Cerrar sesión  | ✅ |


### Tickets
| Método | Ruta   | Descripción  | Requiere autenticación |
|:----------|:--------:|:---------:|:---------:|
| GET | /api/tickets | Retorna todos los tickets  | ✅ |
| GET | /api/tickets/{id} | Retorna un ticket por su id  | ✅ |
| GET | /api/tickets/user/{id} | Retorna todos los tickets de un usuario  | ✅ |
| POST | /api/ticket | Crear ticket  | ✅ |
| POST | /api/ticket/{id}/response | Responder ticket  | ✅ |
| PATCH | /api/ticket/{id}/priority | Cambiar la prioridad (low,medium,high)  | ✅ |
| PATCH | ticket/{id}/status | Cambia el estado (open,in_progress,closed)  | ✅ |
| PATCH | ticket/{id}/toggle | WIP  | ✅ |


## 👤 Autor
#### Alejandro Villarroel
Estudiante de Ingenieria en computacion e informatica
- [Linkedin](https://www.linkedin.com/in/alevillarroel/)