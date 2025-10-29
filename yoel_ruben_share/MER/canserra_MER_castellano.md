# Esquema de Base de Datos - MER (Modelo Entidad-Relación)

Actualizado basado en migraciones reales (Septiembre-Octubre 2025)

## RECOMENDACIONES DE DISEÑO

### RELACIONES POLIMÓRFICAS
- **documents_component**: Utiliza relaciones polimórficas (documentable_id/documentable_type) para adjuntar documentos a cualquier modelo
- **notes_component**: Utiliza relaciones polimórficas (noteable_id/noteable_type) para adjuntar notas a cualquier modelo

### SISTEMA DE EVALUACIÓN
- **evaluations**: Utiliza evaluation_id para agrupar múltiples pares pregunta-respuesta en una sola sesión de evaluación
- **quiz**: Almacena preguntas individuales
- Cada registro de evaluación se vincula a una pregunta del cuestionario con un valor de respuesta (0-3)

---

## TABLAS DEL SISTEMA

### USERS (Usuarios)
- id (INT, PK)
- professional_id (INT, FK → PROFESIONAL, nullable)
- name (VARCHAR(255))
- email (VARCHAR(255))
- password (VARCHAR(255))
- remember_token (VARCHAR(100))
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
- role (ENUM: 'Directiu', 'Administració', 'Tècnic', nullable) -- Rol profesional
- dni (VARCHAR(100), UNIQUE) -- DNI
- phone (VARCHAR(20), nullable)
- email (VARCHAR(255), UNIQUE, nullable)
- address (VARCHAR(500), nullable)
- employment_status (ENUM: 'Actiu', 'Suplència', 'Baixa', 'No contractat', nullable) -- Estado laboral
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
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE REGISTROS

### RECORD (Registro)
- id (INT, PK)
- professional_id (INT, FK → PROFESSIONAL)
- type (ENUM) -- Tipo: 'Seguiment', 'Avaluació', 'Accident', 'Baixa_llarga', 'Observació'
- date (DATE) -- Fecha del registro
- description (TEXT, nullable)
- comments (TEXT, nullable)
- file (VARCHAR(500), nullable) -- Ruta del archivo adjunto
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE FORMACIÓN Y CURSOS

### COURSE (Curso)
- id (INT, PK)
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
- evaluation_id (VARCHAR(255)) -- ID único de evaluación para agrupar registros
- evaluator_professional_id (INT, FK → PROFESSIONAL) -- Profesional evaluador
- evaluated_professional_id (INT, FK → PROFESSIONAL) -- Profesional evaluado
- question_id (INT, FK → QUIZ) -- ID de la pregunta del cuestionario
- answer (INT) -- Valor de respuesta de 0 a 3
- evaluation_date (DATE) -- Fecha de evaluación
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE SERVICIOS Y CONTACTOS

### SERVICE_CONTACT (Contacto de Servicio)
- id (INT, PK)
- type (VARCHAR(100)) -- Tipo: servicio_general, servicio_complementario, contacto_asistencial, contacto_general
- responsible (VARCHAR(255), nullable) -- Persona responsable (texto libre)
- phone (VARCHAR(20), nullable)
- email (VARCHAR(255), nullable)
- observations (TEXT, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### EXTERNAL_CONTACT (Contacto Externo)
- id (INT, PK)
- external_contact_type (VARCHAR(100), nullable) -- Tipo de contacto externo
- service_reason (VARCHAR(255), nullable) -- Motivo del servicio
- company (VARCHAR(255), nullable) -- Nombre de la empresa
- name (VARCHAR(255), nullable) -- Nombre del contacto
- surname (VARCHAR(255), nullable) -- Apellido del contacto
- phone (VARCHAR(20), nullable)
- email (VARCHAR(255), nullable)
- observations (TEXT, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### GENERAL_SERVICE (Servicio General)
- id (INT, PK)
- service_type (VARCHAR(100), nullable) -- Tipo de servicio
- assigned_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional asignado
- contact_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional de contacto
- external_contact_id (INT, FK → EXTERNAL_CONTACT, nullable) -- Referencia a contacto externo
- start_date (DATE, nullable) -- Fecha de inicio del servicio
- end_date (DATE, nullable) -- Fecha de fin del servicio
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### COMPLEMENTARY_SERVICE (Servicio Complementario)
- id (INT, PK)
- service_type (VARCHAR(100), nullable) -- Tipo de servicio
- service_responsible (VARCHAR(255), nullable) -- Responsable del servicio (texto libre)
- start_date (DATE, nullable) -- Fecha de inicio del servicio
- end_date (DATE, nullable) -- Fecha de fin del servicio
- documents (VARCHAR(500), nullable) -- Documentos relacionados
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE SEGUIMIENTOS

### WORK_FOLLOW_UP (Seguimiento Laboral)
- id (INT, PK)
- follow_up_type (VARCHAR(100), nullable) -- Tipo de seguimiento
- follow_up_date (DATE) -- Fecha de seguimiento
- recorder_professional_id (INT, FK → PROFESSIONAL) -- Profesional que registró
- professional_id (INT, FK → PROFESSIONAL) -- Profesional siendo seguido
- topic (VARCHAR(255), nullable) -- Tema del seguimiento
- comment (TEXT, nullable) -- Comentario del seguimiento
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE ACCIDENTES

### ACCIDENT (Accidente)
- id (INT, PK)
- accident_type (VARCHAR(100), nullable) -- Tipo de accidente
- start_date (DATE) -- Fecha de inicio del accidente
- end_date (DATE, nullable) -- Fecha de fin del accidente
- description (TEXT, nullable) -- Descripción del accidente
- reporting_professional_id (INT, FK → PROFESSIONAL) -- Profesional que reportó
- injured_professional_id (INT, FK → PROFESSIONAL) -- Profesional lesionado
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### ACCIDENT_FOLLOW_UP (Seguimiento de Accidente)
- id (INT, PK)
- accident_id (INT, FK → ACCIDENT) -- Referencia al accidente
- professional_id (INT, FK → PROFESSIONAL) -- Referencia al profesional
- follow_up_date (DATE) -- Fecha de seguimiento
- description (TEXT, nullable) -- Descripción del seguimiento
- notes (TEXT, nullable) -- Notas adicionales
- documents (VARCHAR(500), nullable) -- Documentos relacionados
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE MANTENIMIENTOS

### MAINTENANCE (Mantenimiento)
- id (INT, PK)
- opening_date (DATE) -- Fecha de apertura del mantenimiento
- description (TEXT, nullable) -- Descripción del mantenimiento
- assigned_to_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional asignado
- documents (VARCHAR(500), nullable) -- Documentos relacionados
- end_date (DATE, nullable) -- Fecha de fin del mantenimiento
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### MAINTENANCE_FOLLOW_UP (Seguimiento de Mantenimiento)
- id (INT, PK)
- maintenance_id (INT, FK → MAINTENANCE) -- Referencia al mantenimiento
- professional_id (INT, FK → PROFESSIONAL) -- Referencia al profesional
- description (TEXT, nullable) -- Descripción del seguimiento
- documents (VARCHAR(500), nullable) -- Documentos relacionados
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE TEMAS DE RRHH

### HR_ISSUES (Temas de RRHH)
- id (INT, PK)
- date (DATE) -- Fecha del tema
- affected_professional_id (INT, FK → PROFESSIONAL) -- Profesional afectado
- registering_professional_id (INT, FK → PROFESSIONAL) -- Profesional que registró
- referred_to (VARCHAR(255), nullable) -- Derivado a (texto libre)
- documents (VARCHAR(500), nullable) -- Documentos relacionados
- end_date (DATE, nullable) -- Fecha de resolución del tema
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### HR_ISSUES_FOLLOW_UP (Seguimiento de Temas de RRHH)
- id (INT, PK)
- hr_issue_id (INT, FK → HR_ISSUES) -- Referencia al tema de RRHH
- professional_id (INT, FK → PROFESSIONAL) -- Referencia al profesional
- description (TEXT, nullable) -- Descripción del seguimiento
- documents (VARCHAR(500), nullable) -- Documentos relacionados
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## GESTIÓN DE PROYECTOS Y COMISIONES

### PROJECT_COMMISSION (Proyectos y Comisiones)
- id (INT, PK)
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
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### NOTES_COMPONENT (Componente de Notas)
- id (INT, PK)
- notes (TEXT, nullable) -- Contenido de las notas
- noteable_id (INT) -- Polimórfico: ID del modelo relacionado
- noteable_type (VARCHAR(255)) -- Polimórfico: Tipo del modelo relacionado (App\Models\Center, App\Models\Professional, App\Models\ProjectCommission, etc.)
- created_by_professional_id (INT, FK → PROFESSIONAL, nullable) -- Profesional que creó la nota
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

---

## NOTAS IMPORTANTES

### Tablas Obsoletas Removidas
- ACTIVITY (Actividad) - Funcionalidad integrada en PROJECT_COMMISSION
- PROFESSIONAL_ACTIVITY - Funcionalidad integrada en PROJECT_COMMISSION_ASSIGNMENT
- DOCUMENT - Funcionalidad reemplazada por DOCUMENTS_COMPONENT (polimórfico)
- CENTER_DOCUMENTS - Funcionalidad reemplazada por DOCUMENTS_COMPONENT (polimórfico)
- PROFESSIONAL_DOCUMENT - Funcionalidad reemplazada por DOCUMENTS_COMPONENT (polimórfico)
- MATERIAL_ASSIGNMENT_DOCUMENT - Funcionalidad reemplazada por DOCUMENTS_COMPONENT (polimórfico)
- PROJECT_COMMISSION_DOCUMENTS - Funcionalidad reemplazada por DOCUMENTS_COMPONENT (polimórfico)
- PROFESSIONAL_NOTE - Funcionalidad reemplazada por NOTES_COMPONENT (polimórfico)
- CENTER_NOTE - Funcionalidad reemplazada por NOTES_COMPONENT (polimórfico)
- MATERIAL_ASSIGNMENT_NOTE - Funcionalidad reemplazada por NOTES_COMPONENT (polimórfico)
- PROJECT_COMMISSION_NOTE - Funcionalidad reemplazada por NOTES_COMPONENT (polimórfico)

### Cambios Importantes
1. **Sistema polimórfico**: Los documentos y notas ahora usan relaciones polimórficas, permitiendo adjuntar documentos/notas a cualquier modelo sin necesidad de tablas específicas
2. **Sistema de evaluaciones**: Cambió de un campo TEXT `responses` a múltiples registros vinculados a preguntas individuales del cuestionario
3. **Tabla users**: Ahora incluye relación con profesionales
4. **Tabla professionals**: Incluye campo `dni` único y `locker_num`
5. **Tabla centers**: Incluye campo `status`
6. **Tabla project_commissions**: Incluye campo `status` y `estimated_end_date` en lugar de `end_date`
