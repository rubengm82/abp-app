# Esquema de Base de Datos - MER (Modelo Entidad-Relación)

## RECOMENDACIONES DE DISEÑO

### GESTIÓN DE COMENTARIOS Y NOTAS
- **Campos TEXT individuales**: Para observaciones simples (ACTIVIDAD.observaciones, REGISTRO.comentarios, etc.) se mantienen como campos TEXT directos por simplicidad y rendimiento.
- **Tablas separadas para seguimientos**: Los campos de seguimiento múltiple (SEGUIMIENTO_LABORAL, SEGUIMIENTO_MANTENIMIENTO) deberían implementarse como tablas separadas para permitir múltiples entradas por seguimiento.

### GESTIÓN DE DOCUMENTOS
- **Tabla DOCUMENTOS separada**: Se recomienda crear una tabla DOCUMENTOS independiente que referencie cualquier entidad del sistema, permitiendo múltiples archivos por registro, metadatos completos (tamaño, tipo MIME, fecha de subida, usuario) y mejor auditoría.
- **Campos de documentos actuales**: Los campos VARCHAR(500) actuales (ACTIVIDAD.archivo, REGISTRO.archivo, etc.) deberían migrarse a la nueva tabla DOCUMENTOS en la implementación.

### IMPLEMENTACIÓN FUTURA
- **Fase 1**: Mantener estructura actual con campos TEXT y VARCHAR para documentos
- **Fase 2**: Implementar tabla DOCUMENTOS separada y migrar archivos existentes
- **Fase 3**: Crear tablas de seguimiento separadas para SEGUIMIENTO_LABORAL y SEGUIMIENTO_MANTENIMIENTO

---

## TABLAS OBSOLETAS (mantenidas para referencia)

### ACTIVIDAD (Actividad) - OBSOLETA
- id (INT, PK) - OBSOLETA
- tipo (VARCHAR(50)) -- (proyecto, comisión, tema_pendiente, mantenimiento)
- nombre (VARCHAR(255))
- descripción (TEXT)
- fecha_inicio (DATE)
- fecha_fin (DATE, nullable)
- responsable (VARCHAR(255)) -- Por decidir si FK a PROFESIONAL o campo libre
- observaciones (TEXT)
- archivo (VARCHAR(500))

### PROFESIONAL_ACTIVIDAD (Profesional Actividad) - OBSOLETA
- profesional_id (INT, FK → PROFESIONAL) - OBSOLETA
- actividad_id (INT, FK → ACTIVIDAD) - OBSOLETA

---

## CENTRO (Centro)
- id (INT, PK)
- nombre (VARCHAR(255))
- dirección (VARCHAR(500))
- teléfono (VARCHAR(20))
- correo_electrónico (VARCHAR(255))

## PROFESIONAL (Profesional)
- id (INT, PK)
- centro_id (INT, FK → CENTRO)
- rol (VARCHAR(100))
- nombre (VARCHAR(100))
- apellido1 (VARCHAR(100))
- apellido2 (VARCHAR(100))
- teléfono (VARCHAR(20))
- correo_electrónico (VARCHAR(255))
- dirección (VARCHAR(500))
- estado_laboral (ENUM) -- (Activo, Suplencia, Baja)
- currículum_vitae (TEXT)
- usuario_login (VARCHAR(50))
- contraseña (VARCHAR(255))
- taquilla_id (INT, FK → TAQUILLA)
- talla_camiseta (VARCHAR(10))
- talla_pantalón (VARCHAR(10))
- talla_zapato (VARCHAR(10))


## REGISTRO (Registro) - (seguimientos, evaluaciones, accidentes, bajas, etc.)
- id (INT, PK)
- profesional_id (INT, FK → PROFESIONAL)
- tipo (VARCHAR(50)) -- (seguimiento, evaluación, accidente, baja_larga, observación)
- fecha (DATE)
- descripción (TEXT)
- comentarios (TEXT)
- archivo (VARCHAR(500))

## DOCUMENTO (Documento)
- id (INT, PK)
- profesional_id (INT, FK → PROFESIONAL)
- tipo (VARCHAR(100))
- fecha (DATE)
- nombre_archivo (VARCHAR(255))


## TAQUILLA (Taquilla)
- id (INT, PK)
- número_taquilla (VARCHAR(10))
- estado (ENUM) -- (Disponible, Ocupada, Mantenimiento)
- código_llave (VARCHAR(50))

## CURSO (Curso)
- id (INT, PK)
- centro_formación (VARCHAR(255))
- código_forcem (VARCHAR(50))
- horas_totales (INT)
- tipo (VARCHAR(100))
- modalidad_asistencia (ENUM) -- (Presencial, Online, Mixto)
- nombre_formación (VARCHAR(255))
- taller (VARCHAR(255))
- jornada_conferencia (VARCHAR(255))
- congreso (VARCHAR(255))
- asistente (VARCHAR(255))
- fecha_inicio (DATE)
- fecha_fin (DATE)

## ASIGNACIÓN_CURSO (Asignación Curso)
- id (INT, PK)
- profesional_id (INT, FK → PROFESIONAL)
- curso_id (INT, FK → CURSO)
- certificado (ENUM) -- (Entregado, Pendiente)

## SEGUIMIENTO_LABORAL (Seguimiento Laboral)
- id (INT, PK)
- tipo_seguimiento (VARCHAR(100))
- fecha_seguimiento (DATE)
- profesional_registrador_id (INT, FK → PROFESIONAL)
- profesional_id (INT, FK → PROFESIONAL)
- tema (VARCHAR(255))
- comentario (TEXT)

## EVALUACIÓN (Evaluación)
- id (INT, PK)
- profesional_evaluador_id (INT, FK → PROFESIONAL)
- profesional_evaluado_id (INT, FK → PROFESIONAL)
- fecha_evaluación (DATE)
- respuestas (TEXT)

## ACCIDENTE (Accidente)
- id (INT, PK)
- tipo_accidente (VARCHAR(100))
- fecha_inicio (DATE)
- fecha_fin (DATE)
- descripción (TEXT)
- profesional_reportador_id (INT, FK → PROFESIONAL)
- profesional_lesionado_id (INT, FK → PROFESIONAL)

## SEGUIMIENTO_ACCIDENTE (Seguimiento Accidente)
- id (INT, PK)
- accidente_id (INT, FK → ACCIDENTE)
- profesional_id (INT, FK → PROFESIONAL)
- fecha_seguimiento (DATE)
- descripción (TEXT)
- notas (TEXT)
- documentos (VARCHAR(500))

## CONTACTO_SERVICIO (Servicio Contacto) -- (servicios + contactos externos juntos) --
- id (INT, PK)
- tipo (VARCHAR(100)) -- (servicio_general, servicio_complementario, contacto_asistencial, contacto_general)
- responsable (VARCHAR(255)) -- Por decidir si FK a PROFESIONAL o campo libre
- teléfono (VARCHAR(20))
- correo_electrónico (VARCHAR(255))
- observaciones (TEXT)

## SERVICIO_GENERAL (Servicio General)
- id (INT, PK)
- tipo_servicio (VARCHAR(100))
- profesional_asignado_id (INT, FK → PROFESIONAL)
- profesional_contacto_id (INT, FK → PROFESIONAL)
- contacto_externo_id (INT, FK → CONTACTO_EXTERNO)
- fecha_inicio (DATE)
- fecha_fin (DATE)

## SERVICIO_COMPLEMENTARIO (Servicio Complementario)
- id (INT, PK)
- tipo_servicio (VARCHAR(100))
- responsable_servicio (VARCHAR(255)) -- Por decidir si FK a PROFESIONAL o campo libre
- fecha_inicio (DATE)
- fecha_fin (DATE)
- documentos (VARCHAR(500))

## CONTACTO_EXTERNO (Contacto Externo)
- id (INT, PK)
- tipo_contacto_externo (VARCHAR(100))
- motivo_servicio (VARCHAR(255))
- empresa (VARCHAR(255))
- nombre (VARCHAR(255))
- apellido (VARCHAR(255))
- teléfono (VARCHAR(20))
- correo_electrónico (VARCHAR(255))
- observaciones (TEXT)

## MANTENIMIENTO (Mantenimiento)
- id (INT, PK)
- fecha_apertura (DATE)
- descripción (TEXT)
- profesional_asignado_id (INT, FK → PROFESIONAL)
- documentos (VARCHAR(500))
- fecha_fin (DATE) -- Añadido para mantenimientos con duración definida

## SEGUIMIENTO_MANTENIMIENTO (Seguimiento Mantenimiento)
- id (INT, PK)
- mantenimiento_id (INT, FK → MANTENIMIENTO)
- profesional_id (INT, FK → PROFESIONAL)
- descripción (TEXT)
- documentos (VARCHAR(500))

## DOCUMENTOS_CENTRO (Documentos Centro)
- id (INT, PK)
- tipo (VARCHAR(100))
- fecha (DATE)
- descripción (TEXT)
- profesional_id (INT, FK → PROFESIONAL)
- documentos (VARCHAR(500))

## TEMAS_RRHH (Temas RRHH)
- id (INT, PK)
- fecha (DATE)
- profesional_afectado_id (INT, FK → PROFESIONAL)
- profesional_registrador_id (INT, FK → PROFESIONAL)
- derivado_a (VARCHAR(255)) -- Por decidir si FK a PROFESIONAL o campo libre
- documentos (VARCHAR(500))
- fecha_fin (DATE) -- Añadido para temas con resolución definida

## SEGUIMIENTO_TEMAS_RRHH (Seguimientos Temas RRHH)
- id (INT, PK)
- tema_rrhh_id (INT, FK → TEMAS_RRHH)
- profesional_id (INT, FK → PROFESIONAL)
- descripción (TEXT)
- documentos (VARCHAR(500))

## PROYECTO_COMISIÓN (Proyectos y Comisiones)
- id (INT, PK)
- nombre (VARCHAR(255))
- fecha_inicio (DATE)
- fecha_fin (DATE) -- Añadido para proyectos con duración definida
- profesional_responsable_id (INT, FK → PROFESIONAL)
- descripción (TEXT)
- notas (TEXT)
- documentos (VARCHAR(500))
- tipo (ENUM) -- (Proyecto, Comisión)

## ASIGNACIÓN_PROYECTO_COMISIÓN (Asignación Proyectos y Comisiones)
- id (INT, PK)
- proyecto_comisión_id (INT, FK → PROYECTO_COMISIÓN)
- profesional_id (INT, FK → PROFESIONAL)
- fecha_asignación (DATE)
- estado (VARCHAR(50))
- notas (TEXT)

## ASIGNACIÓN_MATERIAL (Asignación de Material)
- id (INT, PK)
- profesional_id (INT, FK → PROFESIONAL)
- tipo_material (VARCHAR(100)) -- (uniforme, epi, equipamiento, otros)
- descripción_material (VARCHAR(255))
- talla (VARCHAR(20)) -- Para uniformes
- fecha_asignación (DATE)
- fecha_renovación_prevista (DATE)
- estado (ENUM) -- (Activo, Renovado, Devuelto, Perdido)
- condición (VARCHAR(50)) -- (Nuevo, Bueno, Regular, Malo)
- profesional_asignador_id (INT, FK → PROFESIONAL)
<!-- - fecha_devolución (DATE) -->
<!-- - fecha_renovación (DATE) -->
- observaciones (TEXT)
- documentos (VARCHAR(500))

