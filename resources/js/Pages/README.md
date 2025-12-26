# 📋 TaskManager - Sistema de Gestión de Tareas

Un sistema moderno y completo para gestionar equipos, proyectos y tareas. TaskManager permite a los equipos colaborar en tiempo real, organizar su trabajo y alcanzar objetivos de manera eficiente.

## 🚀 Características Principales

- **👥 Gestión de Equipos**: Crea y administra equipos de trabajo, invita miembros y colabora sin límites
- **📁 Proyectos Organizados**: Agrupa tareas en proyectos para mantener todo organizado y fácil de seguir
- **✅ Gestión de Tareas**: Crea, asigna y monitorea tareas con prioridades y fechas límite
- **💬 Colaboración en Tiempo Real**: Comenta en tareas y comunícate con tu equipo instantáneamente
- **🎯 Prioridades y Estados**: Filtra tareas por estado, prioridad y asignado para visualizar el progreso
- **📅 Fechas de Vencimiento**: Establece fechas límite y nunca pierdas un plazo importante
- **🔐 Autenticación Segura**: Sistema de login y registro con verificación de email
- **📊 Dashboard Intuitivo**: Panel de control con estadísticas y resumen de actividades

## 💻 Stack Tecnológico

### Backend
- **Laravel 12** - Framework PHP moderno
- **MySQL** - Base de datos relacional
- **Sanctum** - Autenticación API
- **Fortify** - Autenticación y seguridad

### Frontend
- **Vue 3** - Framework JavaScript progresivo
- **TypeScript** - Tipado estático para JavaScript
- **Inertia.js** - Adaptador entre Laravel y Vue
- **Tailwind CSS** - Framework CSS utility-first

### Herramientas de Desarrollo
- **Herd** - Gestor de proyectos local
- **Laravel Debugbar** - Debugging y profiling
- **Laravel Telescope** - Monitoreo de aplicaciones

## 📋 Requisitos Previos

- PHP 8.3 o superior
- Composer
- Node.js 18+ y npm
- MySQL 8.0+
- Laravel Herd (recomendado) o servidor local

## 🔧 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/task-manager-advanced.git
cd task-manager-advanced
```

### 2. Instalar dependencias PHP
```bash
composer install
```

### 3. Configurar el archivo .env
```bash
cp .env.example .env
php artisan key:generate
```

Edita `.env` con tus configuraciones:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager_advanced
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Instalar dependencias Node.js
```bash
npm install
```

### 5. Ejecutar migraciones
```bash
php artisan migrate
```

### 6. Compilar assets (desarrollo)
```bash
npm run dev
```

O para producción:
```bash
npm run build
```

### 7. Acceder a la aplicación
```
http://task-manager-advanced.test (con Herd)
o
http://localhost:8000
```

## 🏗️ Estructura del Proyecto

```
task-manager-advanced/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Team.php
│   │   ├── Project.php
│   │   ├── Task.php
│   │   └── Comment.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── TeamController.php
│   │       ├── ProjectController.php
│   │       ├── TaskController.php
│   │       └── CommentController.php
│   └── Middleware/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   ├── Layouts/
│   │   │   └── AuthenticatedLayout.vue
│   │   └── app.js
│   └── views/
│       ├── Welcome.vue
│       ├── Dashboard.vue
│       ├── Tasks/
│       │   ├── Create.vue
│       │   ├── Edit.vue
│       │   └── Show.vue
│       └── Projects/
│           ├── Index.vue
│           ├── Create.vue
│           ├── Show.vue
│           └── Edit.vue
├── routes/
│   ├── web.php
│   ├── api.php
│   └── auth.php
├── database/
│   ├── migrations/
│   └── seeders/
├── config/
└── public/
```

## 📊 Base de Datos - Modelo Relacional

### Tablas Principales

**users**
- id, name, email, password, email_verified_at, created_at, updated_at

**teams**
- id, name, description, created_at, updated_at

**team_user** (Many-to-Many)
- team_id, user_id, role (admin/member)

**projects**
- id, team_id, name, description, created_at, updated_at

**tasks**
- id, project_id, title, description, status (pending/in_progress/completed)
- priority (low/medium/high), due_date, created_by, assigned_to, created_at, updated_at

**comments**
- id, task_id, user_id, content, created_at, updated_at

## 🔐 Autenticación y Autorización

- **Registro**: Cualquier usuario puede registrarse
- **Login**: Autenticación con email y contraseña
- **Roles**: Admin y miembros de equipo
- **Permisos**: 
  - Solo admins pueden crear/editar tareas
  - Solo miembros del equipo pueden ver proyectos
  - Cualquiera puede comentar en tareas

## 📝 Rutas Principales

### Autenticación
- `POST /register` - Registro de usuario
- `POST /login` - Inicio de sesión
- `POST /logout` - Cerrar sesión

### Equipos
- `GET /teams` - Listar equipos
- `GET /teams/create` - Crear equipo
- `POST /teams` - Guardar equipo
- `GET /teams/{team}` - Ver detalle equipo
- `GET /teams/{team}/edit` - Editar equipo
- `PUT /teams/{team}` - Actualizar equipo
- `DELETE /teams/{team}` - Eliminar equipo

### Proyectos
- `GET /teams/{team}/projects` - Listar proyectos
- `GET /teams/{team}/projects/create` - Crear proyecto
- `POST /teams/{team}/projects` - Guardar proyecto
- `GET /projects/{project}` - Ver detalle proyecto
- `GET /projects/{project}/edit` - Editar proyecto
- `PUT /projects/{project}` - Actualizar proyecto
- `DELETE /projects/{project}` - Eliminar proyecto

### Tareas
- `GET /projects/{project}/tasks` - Listar tareas
- `GET /projects/{project}/tasks/create` - Crear tarea
- `POST /projects/{project}/tasks` - Guardar tarea
- `GET /tasks/{task}` - Ver detalle tarea
- `GET /tasks/{task}/edit` - Editar tarea
- `PUT /tasks/{task}` - Actualizar tarea
- `DELETE /tasks/{task}` - Eliminar tarea

### Comentarios
- `POST /tasks/{task}/comments` - Crear comentario
- `PUT /comments/{comment}` - Editar comentario
- `DELETE /comments/{comment}` - Eliminar comentario

## 🚀 Comenzar a Usar

### 1. Crear una Cuenta
- Dirígete a la página de registro
- Completa el formulario con tus datos
- Verifica tu email

### 2. Crear un Equipo
- Ve al dashboard
- Haz clic en "Crear Equipo"
- Completa los detalles del equipo

### 3. Invitar Miembros
- Accede a tu equipo
- Invita a miembros por email
- Ellos aceptarán la invitación

### 4. Crear Proyectos
- Dentro del equipo, crea un nuevo proyecto
- Asigna una descripción

### 5. Gestionar Tareas
- En cada proyecto, crea tareas
- Asigna prioridades y fechas límite
- Asigna tareas a miembros del equipo
- Comenta y colabora

## 📱 Características del Dashboard

- **Resumen de actividades**: Tareas pendientes, en progreso y completadas
- **Estadísticas**: Gráficos de progreso del equipo
- **Tareas recientes**: Últimas tareas creadas y modificadas
- **Equipos activos**: Acceso rápido a tus equipos

## 🐛 Solución de Problemas Comunes

### Error: "SQLSTATE[HY000]: General error: 1030 Got error"

**Causa**: Base de datos no existe o no está correctamente configurada.

**Solución**:
```bash
# Crear base de datos manualmente
mysql -u root -p
CREATE DATABASE task_manager_advanced;
EXIT;

# Ejecutar migraciones
php artisan migrate
```

---

### Error: "Column not found: 1054 Unknown column 'name' in 'field list'"

**Causa**: Las migraciones no se ejecutaron completamente o falta una columna en la tabla.

**Solución**:
```bash
# Resetear y ejecutar migraciones nuevamente
php artisan migrate:refresh
# Si ya tienes datos, usa:
php artisan migrate:fresh --seed
```

---

### Error: "Undefined property: App\Models\Task::$assigned_to"

**Causa**: La relación `assigned_to` no está cargada correctamente.

**Solución**: En tu modelo Task, asegúrate de cargar la relación:
```php
$task->load(['assignedUser', 'createdBy']);
```

---

### Error: "Route 'tasks.store' not found"

**Causa**: Las rutas no están registradas correctamente en `routes/web.php`.

**Solución**:
```bash
# Limpiar cache de rutas
php artisan route:clear
php artisan route:cache

# Verificar rutas registradas
php artisan route:list | grep tasks
```

---

### Error: "Unable to prepare route [settings/profile] for serialization. Another route has already been assigned name [profile.edit]"

**Causa**: Rutas duplicadas con el mismo nombre.

**Solución**: Elimina las rutas duplicadas de profile en `routes/web.php`:
```php
// ❌ Elimina estas líneas (Fortify las proporciona automáticamente)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
```

---

### Error: "npm run dev no inicia / assets no se compilan"

**Causa**: Dependencias de Node.js no instaladas o corruptas.

**Solución**:
```bash
# Limpiar node_modules
rm -rf node_modules package-lock.json

# Reinstalar dependencias
npm install

# Compilar assets
npm run dev
```

---

### Error: "Base table or view not found: 1146 Table 'task_manager_advanced.comments' doesn't exist"

**Causa**: Falta crear la tabla de comentarios.

**Solución**:
```bash
php artisan make:migration create_comments_table

# En el archivo de migración:
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->text('content');
    $table->foreignId('task_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});

# Ejecutar migración
php artisan migrate
```

---

### Error: "CSRF token mismatch" en formularios

**Causa**: El token CSRF no se está pasando correctamente.

**Solución**: Asegúrate de incluir el token CSRF en formularios:
```html
<input type="hidden" :value="$page.props.csrf_token" name="_token">
```

O usa Inertia.js que lo maneja automáticamente:
```javascript
form.post('/route', { onSuccess: () => {} })
```

---

### Error: "Undefined property: task.name" en Vue

**Causa**: El campo se llama `title` en la BD pero Vue espera `name`.

**Solución 1**: Usa el nombre correcto en Vue:
```vue
{{ task.title }}
```

**Solución 2**: Agrega un accessor en el modelo Task:
```php
public function getNameAttribute()
{
    return $this->title;
}
```

---

### Error: "Failed loading C:\xampp\php\ext\php_xdebug.dll"

**Causa**: Extensión XDebug no está disponible (esto es solo una advertencia).

**Solución**: No es crítico. Si deseas solucionarlo:
```bash
# Descomenta xdebug en php.ini si no está activo
# O ignora la advertencia, no afecta el funcionamiento
```

---

### Error: "WebSocket connection to 'ws://...' failed"

**Causa**: Las extensiones del navegador intentan conectarse a WebSocket.

**Solución**: Esto es normal en desarrollo. Ignora el error. Si lo necesitas:
1. Configura WebSockets en tu aplicación
2. O desactiva las extensiones del navegador

---

### Error: "No tienes acceso a este proyecto" (403)

**Causa**: El usuario no es miembro del equipo.

**Solución**: 
1. Asegúrate de agregar al usuario al equipo
2. Verifica que el equipo existe y tiene miembros
3. Comprueba los permisos en `TeamController`

---

### Error: "Tabla 'tasks' ya existe" al migrar

**Causa**: La migración ya fue ejecutada previamente.

**Solución**:
```bash
# Verifica qué migraciones se ejecutaron
php artisan migrate:status

# Si necesitas resetear todo:
php artisan migrate:refresh
```

---

### Error: "Class not found: App\Models\Comment"

**Causa**: El modelo Comment no existe.

**Solución**:
```bash
php artisan make:model Comment -m
```

---

### Error: "Inertia: route 'projects.tasks.store' is not in the route list"

**Causa**: La ruta anidada no está registrada correctamente.

**Solución**: Verifica en `routes/web.php`:
```php
Route::resource('projects.tasks', TaskController::class)->scoped([
    'task' => 'id',
]);
```

---

### Error: "CORS policy: No 'Access-Control-Allow-Origin' header"

**Causa**: Intento de acceso desde diferente dominio sin CORS configurado.

**Solución**: Si es desarrollo local, esto no debería ocurrir. Si es necesario:
```php
// En config/cors.php
'allowed_origins' => ['http://localhost:3000'],
```

---

### Error: "Memory limit exhausted" durante migraciones

**Causa**: Memoria PHP insuficiente.

**Solución**:
```bash
# Aumenta el límite de memoria
php -d memory_limit=512M artisan migrate
```

O edita `php.ini`:
```
memory_limit = 512M
```

---

### Error: "Skin tone modifier" o advertencias en consola

**Causa**: Emojis o caracteres especiales causando advertencias.

**Solución**: Ignora estas advertencias, no afectan la funcionalidad.

---

### Error: "Cannot read property 'name' of undefined" en Vue

**Causa**: Los datos de las relaciones no están cargados.

**Solución**: Asegúrate de cargar las relaciones en el Controller:
```php
$task->load(['project', 'createdBy', 'assignedUser', 'comments.user']);
```

---

### Error: "Authentication failed" o "Unauthenticated"

**Causa**: Sesión expirada o no autenticado.

**Solución**:
```bash
# Limpia las cookies y sesiones
php artisan cache:clear
php artisan session:clear

# Si es persistente, verifica .env:
SESSION_DRIVER=database
# y ejecuta: php artisan session:table && php artisan migrate
```

---

### Error: "Logging in will redirect you to..." en login

**Causa**: Redirección post-login no configurada.

**Solución**: Verifica en `app/Http/Controllers/Auth/AuthenticatedSessionController.php`:
```php
return redirect()->route('dashboard');
```

---

### Error: "Class 'Illuminate\Pagination\Paginator' not found"

**Causa**: Laravel no cargó completamente.

**Solución**:
```bash
composer dump-autoload
php artisan cache:clear
```

---

## 🧪 Testing (Próximamente)

```bash
php artisan test
```

## 🐛 Reportar Problemas

Si encuentras un bug, por favor:

1. Verifica que el problema no haya sido reportado
2. Describe el problema con claridad
3. Incluye pasos para reproducir el error
4. Proporciona información de tu entorno

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

## 👥 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el repositorio
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📧 Soporte

Para soporte, contacta a: [tu-email@example.com](mailto:tu-email@example.com)

## 🎯 Roadmap

- [ ] Sistema de notificaciones
- [ ] Exportar reportes a PDF
- [ ] Integración con Slack
- [ ] Mobile app
- [ ] Sistema de webhooks
- [ ] API REST completa
- [ ] Tests automatizados
- [ ] Documentación API OpenAPI

## 👨‍💻 Autor

Creado con ❤️ por [Hector Montoya/ Mondev86]

## 🙏 Agradecimientos

- Laravel Community
- Vue.js Community
- Tailwind CSS
- Inertia.js

---

**Versión**: 1.0.0  
**Última actualización**: 26 de Diciembre, 2025
