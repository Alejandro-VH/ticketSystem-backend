# 📋 Sistema de Tickets - backend
Este proyecto corresponde al backend de un Sistema de gestión de **Tickets** desarrollado con **Laravel**. Permite a los usuarios registrar tickets y que estos sean respondidos por el equipo de soporte.

## ✨ Características del sistema
- Registro de usuarios
- Inicio de sesión y autenticación con JWT
- Roles de usuario (Administrador, Soporte y Usuario)
- Creación de Tickets y la capacidad de responderlos
- Gestión de tickets y usuarios (CRUD)

## 🧪 Tecnologías usadas
- PHP 8.4.7
- Laravel 12.8.1
- Docker
- MySQL

## 📋 Requisitos
- PHP
- Composer
- Docker
- Disponibilidad del puerto: 3306

## ⚙️ Instalación
1. Clonar el repositorio
```bash
git clone https://github.com/Alejandro-VH/TicketSystem.git
cd ticketSystem-backend
```

2. Instalar dependencias
```bash
composer install
```

3. Copia el archivo de variables de entorno
```bash
# Windows
copy .env.example .env

# Linux / MacOS
cp .env.example .env
```

4. Genera la clave de la aplicación y el secreto JWT
```bash
php artisan key:generate
php artisan jwt:secret
```

5. Inicia un contenedor con Docker
```bash
docker compose up -d
```

6. Ejecutar migraciones y cargar datos de prueba
```bash
php artisan migrate --seed
```
7. Iniciar aplicación
```bash
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

Puedes ver ejemplos de consumir los endpoints [aquí](/postman/) **(WIP)**

### Usuarios
| Método | Ruta   | Descripción  | Autenticación |
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
| GET | /api/users/{id}/tickets | Retorna todos los tickets de un usuario  | ✅ |
| GET | /api/my-tickets | Retorna todos los tickets del usuario  | ✅ |
| POST | /api/tickets | Crear ticket  | ✅ |
| POST | /api/tickets/{id}/response | Responder ticket  | ✅ |
| PATCH | /api/tickets/{id}/priority | Cambiar la prioridad (low,medium,high)  | ✅ |
| PATCH | /api/tickets/{id}/status | Cambia el estado (open,in_progress,closed)  | ✅ |
| PATCH | /api/tickets/{id}/toggle | Habilita / deshabilita el ticket  | ✅ |


## 👤 Autor
#### Alejandro Villarroel
Estudiante de Ingenieria en computación e informática
- [Linkedin](https://www.linkedin.com/in/alevillarroel/)
