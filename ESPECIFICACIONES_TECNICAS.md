# Especificaciones técnicas del proyecto ABP-App

Documento de especificaciones técnicas de la aplicación y de la base de datos.

---

## 1. Especificaciones de la aplicación

### 1.1 Stack tecnológico

| Componente | Tecnología | Versión |
|------------|------------|---------|
| Backend | PHP | ^8.2 |
| Framework | Laravel | ^12.0 |
| Frontend (assets) | Vite | ^7.0.4 |
| CSS | Tailwind CSS | ^4.1.14 |
| Componentes UI | DaisyUI | ^5.1.27 |
| Plantillas | Blade | (Laravel) |
| Cliente HTTP (dev) | Axios | ^1.11.0 |
| Utilidad (arrastrar/soltar) | Sortable.js | ^1.15.6 |

### 1.2 Estructura de la aplicación

- **Tipo**: Aplicación web monolítica (Laravel full-stack).
- **Arquitectura**: MVC; controladores en `app/Http/Controllers`, modelos en `app/Models`, vistas en `resources/views`.
- **Autenticación**: Sesiones Laravel con middleware `auth` y `guest`; login con selección de centro para rol Gerent.
- **Idioma / zona**: Locale y timezone configurados (`config/app.php`: `timezone` = `Europe/Madrid`).
- **Cola**: Uso de colas (queue) en entorno de desarrollo (`php artisan queue:listen`).

### 1.3 Entradas de build y recursos

- **Vite**: `resources/css/app.css`, `resources/js/app.js`.
- **Refresh (HMR)**: Cambios en `app/Http/Controllers/**`, `app/Models/**`, `resources/views/**`.
- **CSS**: Tailwind con plugin DaisyUI y tema personalizado (oklch) en `resources/css/app.css`.

### 1.4 Rutas y módulos funcionales

Rutas definidas en `routes/web.php`, protegidas con `middleware('auth')` salvo login/logout:

| Módulo | Descripción |
|--------|-------------|
| **Login / Logout** | Login, selección de centro (Gerent), logout. |
| **Centers** | CRUD centros, activar/desactivar, notas, documentos, descarga CSV. |
| **Professionals** | CRUD profesionales, activar/desactivar, notas, documentos, evaluaciones, CSV. |
| **Evaluations** | Listado, formulario y visualización de quiz de evaluación, CSV por evaluación. |
| **HR Issues** | CRUD incidencias RRHH, notas, documentos, CSV. |
| **Professional Accidents** | CRUD accidentes profesionales, notas, documentos, CSV. |
| **Project Commissions** | CRUD proyectos/comisiones, asignación de profesionales, notas, documentos, CSV. |
| **External Contacts** | CRUD contactos externos, notas, documentos, CSV. |
| **Material Assignments** | CRUD asignaciones de material, firma, existencias/roba, notas, documentos, CSV. |
| **Courses** | CRUD cursos, asignación de profesionales, certificados, notas, documentos, CSV. |
| **General Services** | Visualización/edición por tipo de servicio, notas, documentos. |
| **Maintenances** | CRUD mantenimientos, activar/desactivar, notas, documentos, CSV. |
| **Complementary Services** | CRUD servicios complementarios, activar/desactivar, notas, documentos, CSV. |
| **Global Documents** | Listado y descarga de documentos globales. |

### 1.5 Scripts y entorno de desarrollo

- **`composer dev`**: Inicia en paralelo: servidor PHP, queue listener, Pail (logs), Vite.
- **`npm run dev`**: Solo Vite.
- **`npm run build`**: Build de producción con Vite.
- **Tests**: `composer test` → `php artisan test`.

### 1.6 Dependencias de desarrollo (PHP)

- Faker, Laravel Pail, Pint, Sail, Collision, PHPUnit, Mockery, Pest (vía `composer.json` / `composer.lock`).

---

## 2. Especificaciones de la base de datos

### 2.1 Motor y conexión

- **Por defecto**: SQLite (`config/database.php`: `DB_CONNECTION` desde `env`, default `sqlite`).
- **Soportados**: SQLite, MySQL, MariaDB, PostgreSQL, SQL Server (configurados en `config/database.php`).
- **Configuración**: Variables de entorno (`DB_CONNECTION`, `DB_DATABASE`, etc.); SQLite usa `database_path('database.sqlite')`.
- **Migraciones**: Tabla `migrations` con `update_date_on_publish` activado.
- **Claves foráneas**: Habilitadas por defecto en SQLite (`foreign_key_constraints`).

### 2.2 Tablas del sistema (Laravel)

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios de la app (id, timestamps; columnas típicas name/email/password/remember_token añadidas por Laravel; `professional_id` por migración propia). |
| `password_reset_tokens` | Tokens de reseteo de contraseña (email, token, created_at). |
| `sessions` | Sesiones (id, user_id, ip_address, user_agent, payload, last_activity). |
| `cache` / `cache_locks` | Cache (key, value, expiration) y bloqueos. |
| `jobs` / `job_batches` / `failed_jobs` | Cola de trabajos y fallos. |
| `migrations` | Control de migraciones ejecutadas. |

### 2.3 Tablas de dominio

#### Centros y profesionales

| Tabla | Descripción principal |
|-------|------------------------|
| `centers` | id, name, address, phone, email, status, timestamps. |
| `professionals` | id, center_id (FK→centers), name, surname1, surname2, role (Directiu/Administració/Tècnic/Gerent), dni (unique), phone, email (unique), address, employment_status (Actiu/Suplència/No contractat), cvitae, user (unique), password, locker_num, key_code, status, timestamps. |

#### Relación usuarios – profesionales

- `users.professional_id` → `professionals.id` (nullable, on delete cascade).

#### Proyectos y comisiones

| Tabla | Descripción principal |
|-------|------------------------|
| `project_commissions` | id, center_id (FK→centers), name, start_date, estimated_end_date, responsible_professional_id (FK→professionals), description, type (Projecte/Comissió), status (Actiu/Inactiu), timestamps. |
| `project_commission_assignments` | id, project_commission_id (FK→project_commissions), professional_id (FK→professionals), timestamps. |

#### Formación

| Tabla | Descripción principal |
|-------|------------------------|
| `courses` | id, center_id (FK→centers), training_center, forcem_code, total_hours, type, attendance_type (Presencial/Online/Mixto), training_name, workshop, conference_day, congress, attendee, start_date, end_date, timestamps. |
| `course_assignments` | id, professional_id (FK→professionals), course_id (FK→courses), certificate (Entregat/Pendent), timestamps. |

#### Evaluaciones

| Tabla | Descripción principal |
|-------|------------------------|
| `quiz` | id, question (text), timestamps. |
| `evaluations` | id, evaluator_professional_id, evaluated_professional_id (FK→professionals), question_id (FK→quiz), answer (0–3), evaluation_uuid (UUID), timestamps. |
| `evaluation_observations` | id, evaluation_uuid, observation (text), timestamps; índice en evaluation_uuid. |

#### RRHH e incidentes

| Tabla | Descripción principal |
|-------|------------------------|
| `hr_issues` | id, center_id (FK→centers), opening_date, closing_date, affected_professional_id, registering_professional_id, referred_to_professional_id (FK→professionals), description, status (Obert/Tancat), timestamps. |
| `professional_accidents` | id, type (Sense baixa/Amb baixa), date, context, description, created_by_professional_id, affected_professional_id (FK→professionals), duration, start_date, end_date (para “Amb baixa”), timestamps. |

#### Material y mantenimientos

| Tabla | Descripción principal |
|-------|------------------------|
| `material_assignments` | id, professional_id (FK→professionals), shirt_size, pants_size, shoe_size (enums), assignment_date, assigned_by_professional_id (FK→professionals), observations, signature, timestamps. |
| `maintenances` | id, name_maintenance, responsible_maintenance, center_id (FK→centers), description, opening_date_maintenance, ending_date_maintenance, status, timestamps. |

#### Servicios y contactos externos

| Tabla | Descripción principal |
|-------|------------------------|
| `general_services` | id, center_id (FK→centers), service_type, responsible, responsible_info, planning, timestamps. |
| `complementary_services` | id, center_id (FK→centers), service_type, service_responsible, start_date, end_date, description, status, timestamps. |
| `external_contacts` | id, center_id (FK→centers), external_contact_type, service_reason, company, department, name, surname, link, phone, email, observations, timestamps. |

#### Componentes reutilizables (polimórficos)

| Tabla | Descripción principal |
|-------|------------------------|
| `notes_component` | id, notes (text), noteable_id + noteable_type (polimórfico), created_by_professional_id (FK→professionals), restricted, timestamps. |
| `documents_component` | id, file_name, original_name, file_path, file_size, mime_type, documentable_id + documentable_type (polimórfico), uploaded_by_professional_id (FK→professionals), document_type (enum: Organització del Centre, Documents del Departament, … Altres), timestamps. |

### 2.4 Convenciones y relaciones

- **Claves primarias**: `id` (bigInteger unsigned, auto-increment) en tablas de dominio.
- **Temporales**: `created_at` y `updated_at` en tablas principales.
- **Claves foráneas**: Nomenclatura `*_id`; eliminación en cascada o `set null` según migraciones.
- **Polimórficas**: `notes_component` (noteable) y `documents_component` (documentable) vinculan a Center, Professional, ProjectCommission, Course, HrIssue, ProfessionalAccident, MaterialAssignment, Maintenance, ComplementaryService, GeneralService, ExternalContact, etc., según uso en modelos.
- **Índices**: Definidos en migraciones (p. ej. sesiones, cache, jobs, evaluation_uuid).

### 2.5 Modelos Eloquent (resumen)

Cada tabla de dominio tiene su modelo en `app/Models/`:

- User, Professional, Center, ProjectCommission, ProjectCommissionAssignment, Course, CourseAssignment, Evaluation, EvaluationObservation, Quiz, HrIssue, ProfessionalAccident, MaterialAssignment, Maintenance, GeneralService, ComplementaryService, ExternalContact, NotesComponent, DocumentComponent.

El modelo `User` tiene relación `belongsTo(Professional::class)` y accesores para `center` y `center_id` vía profesional.

---

## 3. Resumen

- **App**: Laravel 12 (PHP 8.2), Vite 7, Tailwind 4, DaisyUI; lógica en controladores y modelos; vistas Blade; autenticación por sesión; colas para jobs.
- **Base de datos**: Por defecto SQLite; múltiples conexiones disponibles; esquema basado en centros y profesionales, con proyectos/comisiones, cursos, evaluaciones, RRHH, accidentes, material, mantenimientos, servicios y contactos externos; notas y documentos polimórficos; migraciones versionadas en `database/migrations`.

Este documento se puede ampliar con detalles de permisos por rol, validaciones concretas o variables de entorno necesarias para despliegue.
