# Esquema de Base de Datos - MER (Modelo Entidad-Relación)

Actualizado basado en migraciones reales (Septiembre-Diciembre 2025)

## RECOMENDACIONES DE DISEÑO

### RELACIONES POLIMÓRFICAS
- **documents_component**: Utiliza relaciones polimórficas (documentable_id/documentable_type) para adjuntar documentos a cualquier modelo
- **notes_component**: Utiliza relaciones polimórficas (noteable_id/noteable_type) para adjuntar notas a cualquier modelo

### SISTEMA DE EVALUACIÓN
- **evaluations**: Utiliza evaluation_uuid (UUID) para agrupar múltiples pares pregunta-respuesta en una sola sesión de evaluación
- **quiz**: Almacena preguntas individuales
- **evaluation_observations**: Almacena observaciones/comentarios para cada grupo de evaluación
- Cada registro de evaluación se vincula a una pregunta del cuestionario con un valor de respuesta (0-3)

### GESTIÓN DE ACCIDENTES
- **professional_accidents**: Reemplaza las antiguas tablas ACCIDENT y ACCIDENT_FOLLOW_UP
- Soporta tres tipos: 'Sin baixa', 'Amb baixa', 'Baixa Finalitzada'

---

## TABLAS DEL SISTEMA

### USERS (Usuarios)
- id (INT, PK)
- professional_id (INT, FK → PROFESIONAL, nullable)
- name (VARCHAR(255), nullable)
- email (VARCHAR(255), nullable)
- password (VARCHAR(255), nullable)
- remember_token (VARCHAR(100), nullable)
- email_verified_at (TIMESTAMP, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### CENTER (Centro)
- id (INT, PK)
- name (VARCHAR(100))
- address (VARCHAR(100), nullable)
- phone (VARCHAR(50), nullable)
- email (VARCHAR(100), nullable)
- status (INT, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### PROFESSIONAL (Profesional)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable)
- name (VARCHAR(100)) -- Primer nombre
- surname1 (VARCHAR(100)) -- Primer apellido
- surname2 (VARCHAR(100), nullable) -- Segundo apellido
- role (ENUM: 'Directiu', 'Administració', 'Tècnic', 'Gerent', nullable) -- Rol profesional
- dni (VARCHAR(100), UNIQUE) -- DNI
- phone (VARCHAR(20), nullable)
- email (VARCHAR(255), UNIQUE, nullable)
- address (VARCHAR(500), nullable)
- employment_status (ENUM: 'Actiu', 'Suplència', 'No contractat', nullable) -- Estado laboral
- is_on_leave (BOOLEAN, default: false) -- ¿Está el profesional de baja?
- cvitae (TEXT, nullable) -- Currículum vitae
- user (VARCHAR(50), UNIQUE, nullable) -- Usuario de login
- password (VARCHAR(255), nullable)
- locker_num (VARCHAR(50), nullable) -- Número de taquilla
- key_code (VARCHAR(50), nullable) -- Código de llave
- status (INT, nullable) -- (1=Activo, 0=Inactivo)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE MATERIAL Y EQUIPAMIENTO

### MATERIAL_ASSIGNMENT (Asignación de Material)
- id (INT, PK)
- professional_id (INT, FK → PROFESSIONAL)
- shirt_size (ENUM, nullable) -- Talla de camiseta: 'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '36', '38', '40', '42', '44', '46', '48', '50', '52', '54', '56'
- pants_size (ENUM, nullable) -- Talla de pantalón: 'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '36', '38', '40', '42', '44', '46', '48', '50', '52', '54', '56'
- shoe_size (ENUM, nullable) -- Talla de zapato: '34' a '56'
- assignment_date (DATE) -- Fecha de asignación
- assigned_by_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional que asignó
- observations (TEXT, nullable)
- signature (TEXT, nullable) -- Firma del profesional
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE FORMACIÓN Y CURSOS

### COURSE (Curso)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- training_center (VARCHAR(255), nullable) -- Centro de formación
- forcem_code (VARCHAR(50), nullable) -- Código FORCEM
- total_hours (INT, nullable) -- Horas totales del curso
- type (VARCHAR(100), nullable) -- Tipo de curso
- attendance_type (ENUM: 'Presencial', 'Online', 'Mixto', nullable) -- Modalidad de asistencia
- training_name (VARCHAR(255), nullable) -- Nombre de la formación
- workshop (VARCHAR(255), nullable) -- Taller
- conference_day (VARCHAR(255), nullable) -- Jornada/conferencia
- congress (VARCHAR(255), nullable) -- Congreso
- attendee (VARCHAR(255), nullable) -- Asistente
- start_date (DATE, nullable) -- Fecha de inicio
- end_date (DATE, nullable) -- Fecha de fin
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### COURSE_ASSIGNMENT (Asignación Curso)
- id (INT, PK)
- professional_id (INT, FK → PROFESSIONAL)
- course_id (INT, FK → COURSE)
- certificate (ENUM: 'Entregat', 'Pendent', default: 'Pendent') -- Estado del certificado
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE CUESTIONARIOS Y EVALUACIONES

### QUIZ (Cuestionario)
- id (INT, PK)
- question (TEXT, nullable) -- Pregunta
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### EVALUATION (Evaluación)
- id (INT, PK)
- evaluation_uuid (UUID) -- UUID único de evaluación para agrupar registros
- evaluator_professional_id (INT, FK → PROFESSIONAL) -- Profesional evaluador
- evaluated_professional_id (INT, FK → PROFESSIONAL) -- Profesional evaluado
- question_id (INT, FK → QUIZ) -- ID de la pregunta del cuestionario
- answer (INT) -- Valor de respuesta de 0 a 3
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### EVALUATION_OBSERVATIONS (Observaciones de Evaluación)
- id (INT, PK)
- evaluation_uuid (UUID) -- Referencia UUID de evaluación para agrupar evaluaciones
- observation (TEXT, nullable) -- Observación/comentario para la evaluación
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE SERVICIOS Y CONTACTOS

### EXTERNAL_CONTACT (Contacto Externo)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- external_contact_type (VARCHAR(100), nullable) -- Tipo de contacto externo
- service_reason (VARCHAR(255), nullable) -- Motivo del servicio
- company (VARCHAR(255), nullable) -- Nombre de la empresa
- department (VARCHAR(255), nullable) -- Departamento
- name (VARCHAR(255), nullable) -- Nombre del contacto
- surname (VARCHAR(255), nullable) -- Apellido del contacto
- link (VARCHAR(500), nullable) -- Enlace
- phone (VARCHAR(20), nullable)
- email (VARCHAR(255), nullable)
- observations (TEXT, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### GENERAL_SERVICE (Servicio General)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- service_type (VARCHAR(100)) -- Tipo de servicio
- responsible (VARCHAR(255), nullable) -- Responsable
- responsible_info (TEXT, nullable) -- Información de contacto del responsable
- planning (TEXT, nullable) -- Planificación
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### COMPLEMENTARY_SERVICE (Servicio Complementario)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- service_type (VARCHAR(255), nullable) -- Tipo de servicio
- service_responsible (VARCHAR(255), nullable) -- Responsable del servicio
- start_date (DATE) -- Fecha de inicio del servicio
- end_date (DATE, nullable) -- Fecha de fin del servicio
- status (INT, nullable) -- Estado del servicio
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE MANTENIMIENTOS

### MAINTENANCE (Mantenimiento)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- name_maintenance (VARCHAR(100)) -- Nombre del mantenimiento
- responsible_maintenance (VARCHAR(100), nullable) -- Persona/Empresa que realiza el mantenimiento
- description (TEXT, nullable) -- Descripción del mantenimiento
- opening_date_maintenance (DATE) -- Fecha de apertura del mantenimiento
- ending_date_maintenance (DATE, nullable) -- Fecha de cierre del mantenimiento
- status (INT, nullable) -- Estado del mantenimiento
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE TEMAS DE RRHH

### HR_ISSUES (Temas de RRHH)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- opening_date (DATE) -- Fecha de apertura del tema
- closing_date (DATE, nullable) -- Fecha de cierre del tema
- affected_professional_id (INT, FK → PROFESSIONAL) -- Profesional afectado
- registering_professional_id (INT, FK → PROFESSIONAL) -- Profesional que registró
- referred_to_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional al que se deriva
- description (TEXT) -- Descripción del tema
- status (ENUM: 'Obert', 'Tancat', default: 'Obert') -- Estado del tema
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE PROYECTOS Y COMISIONES

### PROJECT_COMMISSION (Proyectos y Comisiones)
- id (INT, PK)
- center_id (INT, FK → CENTER, nullable) -- Referencia al centro
- name (VARCHAR(255)) -- Nombre del proyecto/comisión
- start_date (DATE, nullable) -- Fecha de inicio
- estimated_end_date (DATE, nullable) -- Fecha de fin estimada
- responsible_professional_id (INT, FK → PROFESSIONAL) -- Profesional responsable
- description (TEXT, nullable) -- Descripción del proyecto
- type (ENUM: 'Projecte', 'Comissió', nullable) -- Tipo: Proyecto o Comisión
- status (ENUM: 'Actiu', 'Inactiu', nullable) -- Estado: Activo o Inactivo
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### PROJECT_COMMISSION_ASSIGNMENT (Asignación de Proyectos y Comisiones)
- id (INT, PK)
- project_commission_id (INT, FK → PROJECT_COMMISSION) -- Referencia al proyecto/comisión
- professional_id (INT, FK → PROFESSIONAL) -- Referencia al profesional
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE ACCIDENTES

### PROFESSIONAL_ACCIDENT (Accidente Profesional)
- id (INT, PK)
- type (ENUM: 'Sin baixa', 'Amb baixa', 'Baixa Finalitzada') -- Tipo de accidente: sin baja, con baja, o baja finalizada
- date (DATE) -- Fecha del accidente
- context (TEXT, nullable) -- Contexto del accidente
- description (TEXT, nullable) -- Descripción del accidente
- created_by_professional_id (INT, FK → PROFESSIONAL) -- Profesional que creó el registro
- affected_professional_id (INT, FK → PROFESSIONAL) -- Profesional afectado
- duration (INT, nullable) -- Duración de la baja en días (para tipo 'Amb baixa')
- start_date (DATE, nullable) -- Fecha de inicio de la baja (para tipo 'Amb baixa')
- end_date (DATE, nullable) -- Fecha de fin de la baja (para tipo 'Amb baixa')
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## COMPONENTES POLIMÓRFICOS DE DOCUMENTOS Y NOTAS

### DOCUMENTS_COMPONENT (Componente de Documentos)
- id (INT, PK)
- file_name (VARCHAR(255)) -- Nombre del archivo hasheado almacenado en el sistema de archivos
- original_name (VARCHAR(255)) -- Nombre original del archivo subido por el usuario
- file_path (VARCHAR(500), nullable) -- Ruta donde se almacena el archivo en el sistema de archivos
- file_size (INT, nullable) -- Tamaño del archivo en bytes
- mime_type (VARCHAR(100), nullable) -- Tipo MIME del archivo
- documentable_id (INT) -- Polimórfico: ID del modelo relacionado
- documentable_type (VARCHAR(255)) -- Polimórfico: Tipo del modelo relacionado (App\Models\Center, App\Models\ProjectCommission, etc.)
- uploaded_by_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional que subió el documento
- document_type (ENUM, default: 'Altres', nullable) -- Tipo de documento: 'Organització del Centre', 'Documents del Departament', 'Memòries i Seguiment anual', 'PRL', 'Comitè Empresa', 'Informes profesionales', 'Informes persones usuàries', 'Qualitat i ISO', 'Projectes', 'Comissions', 'Famílies', 'Comunicació i Reunions', 'Altres'
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### NOTES_COMPONENT (Componente de Notas)
- id (INT, PK)
- notes (TEXT, nullable) -- Contenido de las notas
- noteable_id (INT) -- Polimórfico: ID del modelo relacionado
- noteable_type (VARCHAR(255)) -- Polimórfico: Tipo del modelo relacionado (App\Models\Center, App\Models\Professional, App\Models\ProjectCommission, etc.)
- created_by_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional que creó la nota
- restricted (INT, nullable) -- Bandera de nota restringida por rol
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## NOTAS IMPORTANTES

### Cambios Importantes desde la Versión Anterior

1. **Sistema polimórfico**: Los documentos y notas ahora usan relaciones polimórficas, permitiendo adjuntar documentos/notas a cualquier modelo sin necesidad de tablas específicas

2. **Sistema de evaluaciones**: 
   - Cambió de un campo TEXT `responses` a múltiples registros vinculados a preguntas individuales del cuestionario
   - Usa `evaluation_uuid` (UUID) en lugar de `evaluation_id` (VARCHAR)
   - Nueva tabla `evaluation_observations` para almacenar observaciones por grupo de evaluación

3. **Tabla users**: Ahora incluye relación con profesionales y campos estándar de Laravel (name, email, password, etc.)

4. **Tabla professionals**: 
   - Incluye campo `dni` único y `locker_num`
   - Nuevo rol 'Gerent' en el enum
   - Nuevo campo `is_on_leave` (boolean) separado del estado laboral
   - `employment_status` ya no incluye 'Baixa' (se maneja con `is_on_leave`)

5. **Tabla centers**: Incluye campo `status`

6. **Tabla project_commissions**: Incluye campo `status`, `estimated_end_date` y `center_id`

7. **Tabla courses**: Ahora incluye `center_id`

8. **Tabla material_assignments**: Incluye campo `signature`

9. **Tabla external_contacts**: 
   - Incluye `center_id`, `department` y `link`
   - Estructura diferente a la versión anterior

10. **Tabla general_services**: 
    - Estructura completamente diferente: ahora tiene `center_id`, `responsible`, `responsible_info`, `planning`
    - Ya no tiene `assigned_professional_id`, `contact_professional_id`, `external_contact_id`, `start_date`, `end_date`

11. **Tabla complementary_services**: 
    - Incluye `center_id` y `status`
    - Ya no tiene campo `documents`

12. **Tabla maintenances**: 
    - Estructura diferente: `name_maintenance`, `responsible_maintenance`, `opening_date_maintenance`, `ending_date_maintenance`, `status`, `center_id`
    - Ya no tiene `assigned_to_professional_id` ni `documents`
    - Ya no existe tabla `maintenance_follow_ups`

13. **Tabla hr_issues**: 
    - Estructura diferente: `opening_date`, `closing_date`, `referred_to_professional_id` (FK), `status` (enum), `center_id`, `description`
    - Ya no tiene `date`, `end_date`, `referred_to` (VARCHAR), `documents`
    - Ya no existe tabla `hr_issues_follow_ups`

14. **Tabla professional_accidents**: 
    - Nueva tabla que reemplaza `accidents` y `accident_follow_ups`
    - Soporta tres tipos: 'Sin baixa', 'Amb baixa', 'Baixa Finalitzada'
    - Incluye campos para gestión de bajas: `duration`, `start_date`, `end_date`

15. **Tabla documents_component**: 
    - Incluye campo `document_type` (enum) con categorías predefinidas

16. **Tabla notes_component**: 
    - Incluye campo `restricted` para control de acceso por rol

### Tablas Obsoletas Removidas
- **RECORD** - Existe en migraciones pendientes pero no está migrada
- **WORK_FOLLOW_UP** - Existe en migraciones pendientes pero no está migrada
- **SERVICE_CONTACT** - Existe en migraciones pendientes pero no está migrada
- **ACCIDENT** - Reemplazada por PROFESSIONAL_ACCIDENT
- **ACCIDENT_FOLLOW_UP** - Reemplazada por PROFESSIONAL_ACCIDENT
- **MAINTENANCE_FOLLOW_UP** - Ya no existe
- **HR_ISSUES_FOLLOW_UP** - Ya no existe

### Tablas Nuevas
- **EVALUATION_OBSERVATIONS** - Para almacenar observaciones de evaluaciones
- **PROFESSIONAL_ACCIDENT** - Nueva tabla unificada para gestión de accidentes
