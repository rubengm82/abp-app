# Documentación de Procesos de la Aplicación ABP

## Índice
1. [Arquitectura General](#arquitectura-general)
2. [Flujo CRUD Completo](#flujo-crud-completo)
3. [Procesos por Entidad](#procesos-por-entidad)
4. [Sistema de Notas y Documentos](#sistema-de-notas-y-documentos)
5. [Navegación y Rutas](#navegación-y-rutas)
6. [Flujos de Datos](#flujos-de-datos)

---

## Arquitectura General

### Patrón MVC Implementado
- **Modelos**: `app/Models/` - Manejo de datos y relaciones
- **Controladores**: `app/Http/Controllers/` - Lógica de negocio
- **Vistas**: `resources/views/components/contents/` - Interfaz de usuario
- **Rutas**: `routes/web.php` - Definición de endpoints

### Estructura de Archivos por Entidad
```
app/Models/
├── Center.php
├── Professional.php
├── MaterialAssignment.php
├── ProjectCommission.php
└── [Notas/Documentos]/
├── CenterNote.php
├── CenterDocument.php
├── ProfessionalNote.php
├── ProfessionalDocument.php
└── ...

app/Http/Controllers/
├── CenterController.php
├── ProfessionalController.php
├── MaterialAssignmentController.php
├── ProjectCommissionController.php
└── [Notas/Documentos]/
├── CenterNoteController.php
├── CenterDocumentController.php
└── ...

resources/views/components/contents/
├── center/
│   ├── centersList.blade.php
│   ├── centerForm.blade.php
│   ├── centerEdit.blade.php
│   └── centerShow.blade.php
├── professional/
│   ├── professionalsList.blade.php
│   ├── professionalForm.blade.php
│   ├── professionalEdit.blade.php
│   └── professionalShow.blade.php
└── ...
```

---

## Flujo CRUD Completo

### 1. LISTADO (Index)
**Archivos involucrados:**
- `Controller::index()` → `View::List.blade.php`

**Proceso:**
1. Usuario accede a `/loquesea_list`
2. `Controller::index()` ejecuta consulta a base de datos
3. Retorna vista con datos
4. Vista renderiza tabla con botones de acción

**Ejemplo - Centros:**
```php
// routes/web.php
Route::get('/centers_list', [CenterController::class, "index"])->name("centers_list");

// CenterController.php
public function index(Request $request) {
    $centers = Center::all();
    return view("components.contents.center.centersList")->with('centers', $centers);
}

// centersList.blade.php
@foreach($centers as $center)
    <a href="{{ route('center_show', $center->id) }}">Veure</a>
    <a href="{{ route('center_edit', $center) }}">Editar</a>
@endforeach
```

### 2. CREACIÓN (Create/Store)
**Archivos involucrados:**
- `Controller::create()` → `View::Form.blade.php` → `Controller::store()`

**Proceso:**
1. Usuario accede a `/loqsea_form`
2. `Controller::create()` retorna formulario vacío
3. Usuario completa formulario y envía POST
4. `Controller::store()` valida y guarda datos
5. Redirección con mensaje de éxito

**Ejemplo - Centros:**
```php
// routes/web.php
Route::get('/center_form', [CenterController::class, "create"])->name("center_form");
Route::post('/center_add', [CenterController::class, "store"])->name("center_add");

// CenterController.php
public function create() {
    return view("components.contents.center.centerForm");
}

public function store(Request $request) {
    Center::create([
        'name' => $request->input('name'),
        'address' => $request->input('address'),
        'phone' => $request->input('phone'),
        'email' => $request->input('email'),
        'status' => '1',
    ]);
    return redirect()->route('center_form')->with('success_added', 'Centre afegit correctament!');
}
```

### 3. VISUALIZACIÓN (Show)
**Archivos involucrados:**
- `Controller::show()` → `View::Show.blade.php`

**Proceso:**
1. Usuario hace clic en "Veure" desde listado
2. `Controller::show()` carga entidad con relaciones
3. Vista muestra datos completos + notas + documentos
4. Botones para editar, eliminar, añadir notas/documentos

**Ejemplo - Centros:**
```php
// routes/web.php
Route::get('/center_show/{id}', [CenterController::class, "show"])->name("center_show");

// CenterController.php
public function show(string $id) {
    $center = Center::with(['notes', 'documents'])->findOrFail($id);
    return view('components.contents.center.centerShow')->with('center', $center);
}

// centerShow.blade.php
<h1>{{ $center->name }}</h1>
<p>{{ $center->address }}</p>

<!-- Sección de Documentos -->
@foreach($center->documents->sortByDesc('created_at') as $document)
    <a href="{{ route('center_document_download', $document) }}">{{ $document->original_name }}</a>
@endforeach

<!-- Sección de Notas -->
@foreach($center->notes->sortByDesc('created_at') as $note)
    <p>{{ $note->notes }}</p>
@endforeach
```

### 4. EDICIÓN (Edit/Update)
**Archivos involucrados:**
- `Controller::edit()` → `View::Edit.blade.php` → `Controller::update()`

**Proceso:**
1. Usuario hace clic en "Editar" desde show o listado
2. `Controller::edit()` carga entidad con datos actuales
3. Vista muestra formulario pre-rellenado
4. Usuario modifica y envía PUT/PATCH
5. `Controller::update()` valida y actualiza
6. Redirección con mensaje de éxito

**Ejemplo - Centros:**
```php
// routes/web.php
Route::get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::post('/center/{center}', [CenterController::class, "update"])->name("center_update");

// CenterController.php
public function edit(Center $center) {
    return view('components.contents.center.centerEdit')->with('center', $center);
}

public function update(Request $request, Center $center) {
    $center->update([
        'name' => $request->input('name'),
        'address' => $request->input('address'),
        'phone' => $request->input('phone'),
        'email' => $request->input('email'),
    ]);
    return redirect()->route('center_show', $center)->with('success_updated', 'Centre actualitzat correctament!');
}
```

### 5. ELIMINACIÓN (Destroy)
**Archivos involucrados:**
- `Controller::destroy()` (generalmente desde show o listado)

**Proceso:**
1. Usuario hace clic en "Eliminar"
2. Confirmación JavaScript (opcional)
3. `Controller::destroy()` elimina registro
4. Redirección con mensaje de confirmación

---

## Procesos por Entidad

### CENTROS (Centers)
**Controlador Principal:** `CenterController.php`
**Modelo:** `Center.php`
**Vistas:** `center/` (centersList, centerForm, centerEdit, centerShow)

**Funcionalidades adicionales:**
- Activación/Desactivación: `activateStatus()`, `desactivateStatus()`
- Descarga CSV: `downloadCSV()`
- Sistema de notas: `CenterNoteController`
- Sistema de documentos: `CenterDocumentController`

### PROFESIONALES (Professionals)
**Controlador Principal:** `ProfessionalController.php`
**Modelo:** `Professional.php`
**Vistas:** `professional/` (professionalsList, professionalForm, professionalEdit, professionalShow)

**Funcionalidades adicionales:**
- Activación/Desactivación: `activateStatus()`, `desactivateStatus()`
- Descarga CSV de asignaciones de material: `downloadCSVMaterialAssignments()`
- Sistema de notas: `ProfessionalNoteController`
- Sistema de documentos: `ProfessionalDocumentController`

### ASIGNACIONES DE MATERIAL (Material Assignments)
**Controlador Principal:** `MaterialAssignmentController.php`
**Modelo:** `MaterialAssignment.php`
**Vistas:** `materialassignment/` (materialAssignmentsList, materialAssignmentForm, materialAssignmentEdit, materialAssignmentShow)

**Funcionalidades especiales:**
- Gestión de tallas de uniforme (camiseta, pantalón, zapato)
- Sistema de notas: `MaterialAssignmentNoteController`
- Sistema de documentos: `MaterialAssignmentDocumentController`

### PROYECTOS Y COMISIONES (Project Commissions)
**Controlador Principal:** `ProjectCommissionController.php`
**Modelo:** `ProjectCommission.php`
**Vistas:** `projectcommission/` (projectCommissionsList, projectCommissionForm, projectCommissionEdit, projectCommissionShow)

**Funcionalidades especiales:**
- Sistema de notas: `ProjectCommissionNoteController`
- Sistema de documentos: `ProjectCommissionDocumentController`
- Soporte para múltiples archivos simultáneos

---

## Sistema de Notas y Documentos

### Arquitectura del Sistema
Cada entidad principal (Center, Professional, MaterialAssignment, ProjectCommission) tiene:
- **Tabla de notas**: `{entity}_notes` (ej: `center_notes`)
- **Tabla de documentos**: `{entity}_documents` (ej: `center_documents`)
- **Controladores específicos**: `{Entity}NoteController`, `{Entity}DocumentController`
- **Modelos específicos**: `{Entity}Note`, `{Entity}Document`

### Flujo de Notas

#### 1. Añadir Nota
**Archivos involucrados:**
- `View::Show.blade.php` (modal) → `{Entity}NoteController::store()`

**Proceso:**
```php
// Vista (ej: centerShow.blade.php)
<dialog id="addNoteModal" class="modal">
    <form action="{{ route('center_note_add', $center) }}" method="POST">
        @csrf
        <textarea name="notes" required></textarea>
        <button type="submit">Afegir Nota</button>
    </form>
</dialog>

// Ruta
Route::post('/center/{center}/notes', [CenterNoteController::class, 'store'])->name('center_note_add');

// Controlador
public function store(Request $request, Center $center) {
    $createdByProfessionalId = auth()->user()->professional_id ?? null;
    if (!$createdByProfessionalId) {
        $firstProfessional = Professional::where('status', 1)->first();
        $createdByProfessionalId = $firstProfessional->id;
    }
    
    CenterNote::create([
        'center_id' => $center->id,
        'notes' => $request->input('notes'),
        'created_by_professional_id' => $createdByProfessionalId
    ]);
    
    return redirect()->route('center_show', $center)->with('success_note_added', 'Nota afegida correctament!');
}
```

#### 2. Editar Nota
**Proceso:**
1. Usuario hace clic en "Editar" en nota existente
2. Modal se abre con contenido actual
3. `{Entity}NoteController::update()` actualiza registro
4. Redirección con mensaje de éxito

#### 3. Eliminar Nota
**Proceso:**
1. Usuario hace clic en "Eliminar" en nota existente
2. Confirmación JavaScript
3. `{Entity}NoteController::destroy()` elimina registro
4. Redirección con mensaje de confirmación

### Flujo de Documentos

#### 1. Subir Documento
**Archivos involucrados:**
- `View::Show.blade.php` (modal) → `{Entity}DocumentController::store()`

**Proceso:**
```php
// Vista (ej: centerShow.blade.php)
<dialog id="addDocumentModal" class="modal">
    <form action="{{ route('center_document_add', $center) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt" required>
        <button type="submit">Pujar Document</button>
    </form>
</dialog>

// Ruta
Route::post('/center/{center}/documents', [CenterDocumentController::class, 'store'])->name('center_document_add');

// Controlador
public function store(Request $request, Center $center) {
    $request->validate(['document' => 'required|file|max:10240']);
    
    $uploadedByProfessionalId = auth()->user()->professional_id ?? null;
    if (!$uploadedByProfessionalId) {
        $firstProfessional = Professional::where('status', 1)->first();
        $uploadedByProfessionalId = $firstProfessional->id;
    }
    
    $file = $request->file('document');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = $file->storeAs('documents/centers', $fileName, 'public');
    
    CenterDocument::create([
        'center_id' => $center->id,
        'file_name' => $fileName,
        'original_name' => $file->getClientOriginalName(),
        'file_path' => $filePath,
        'file_size' => $file->getSize(),
        'mime_type' => $file->getMimeType(),
        'uploaded_by_professional_id' => $uploadedByProfessionalId
    ]);
    
    return redirect()->route('center_show', $center)->with('success_document_added', 'Document afegit correctament!');
}
```

#### 2. Descargar Documento
**Proceso:**
```php
// Vista
<a href="{{ route('center_document_download', $document) }}">{{ $document->original_name }}</a>

// Ruta
Route::get('/center/documents/{document}/download', [CenterDocumentController::class, 'download'])->name('center_document_download');

// Controlador
public function download(CenterDocument $document) {
    return Storage::disk('public')->download($document->file_path, $document->original_name);
}
```

#### 3. Eliminar Documento
**Proceso:**
1. Usuario hace clic en "Eliminar" en documento existente
2. Confirmación JavaScript
3. `{Entity}DocumentController::destroy()` elimina registro
4. Redirección con mensaje de confirmación

---

## Navegación y Rutas

### Estructura de Rutas
```php
// routes/web.php

/* RUTAS PRINCIPALES */
Route::get('/home', function () { return view('app'); })->name('home');
Route::get('/', function () { return view('login'); })->name('login');

/* RUTAS POR ENTIDAD - Patrón CRUD */
// Centros
Route::get('/center_form', [CenterController::class, "create"])->name("center_form");
Route::post('/center_add', [CenterController::class, "store"])->name("center_add");
Route::get('/centers_list', [CenterController::class, "index"])->name("centers_list");
Route::get('/center_show/{id}', [CenterController::class, "show"])->name("center_show");
Route::get('/center/center_edit/{center}', [CenterController::class, 'edit'])->name('center_edit');
Route::post('/center/{center}', [CenterController::class, "update"])->name("center_update");

/* RUTAS DE NOTAS Y DOCUMENTOS - Patrón RESTful */
// Notas de Centros
Route::post('/center/{center}/notes', [CenterNoteController::class, 'store'])->name('center_note_add');
Route::put('/center/notes/{note}', [CenterNoteController::class, 'update'])->name('center_note_update');
Route::delete('/center/notes/{note}', [CenterNoteController::class, 'destroy'])->name('center_note_delete');

// Documentos de Centros
Route::post('/center/{center}/documents', [CenterDocumentController::class, 'store'])->name('center_document_add');
Route::delete('/center/documents/{document}', [CenterDocumentController::class, 'destroy'])->name('center_document_delete');
Route::get('/center/documents/{document}/download', [CenterDocumentController::class, 'download'])->name('center_document_download');
```

### Convenciones de Nomenclatura
- **Rutas principales**: `{entity}_form`, `{entity}_add`, `{entity}_list`, `{entity}_show`, `{entity}_edit`, `{entity}_update`
- **Rutas de notas**: `{entity}_note_add`, `{entity}_note_update`, `{entity}_note_delete`
- **Rutas de documentos**: `{entity}_document_add`, `{entity}_document_delete`, `{entity}_document_download`

---

## Flujos de Datos

### 1. Flujo de Creación Completo
```
Usuario → /center_form → CenterController::create() → centerForm.blade.php
Usuario completa formulario → POST /center_add → CenterController::store()
Validación → Center::create() → Base de datos
Redirección → center_form con mensaje de éxito
```

### 2. Flujo de Visualización con Notas/Documentos
```
Usuario → /center_show/1 → CenterController::show()
Center::with(['notes', 'documents'])->findOrFail(1) → centerShow.blade.php
Renderizado de datos + notas + documentos
Botones para añadir/editar/eliminar notas y documentos
```

### 3. Flujo de Añadir Nota
```
Usuario hace clic en "Afegir Nota" → Modal se abre
Usuario escribe nota → POST /center/{center}/notes
CenterNoteController::store() → Validación → CenterNote::create()
Redirección → center_show con mensaje de éxito
```

### 4. Flujo de Subir Documento
```
Usuario hace clic en "Pujar Document" → Modal se abre
Usuario selecciona archivo → POST /center/{center}/documents (multipart/form-data)
CenterDocumentController::store() → Validación → Procesamiento de archivo
Archivo se guarda en storage/app/public/documents/ + registro en BD con file_path
Redirección → center_show con mensaje de éxito
```

### 5. Flujo de Descarga de Documento
```
Usuario hace clic en enlace de documento → GET /center/documents/{document}/download
CenterDocumentController::download() → Lectura de archivo desde filesystem usando file_path
Response con headers apropiados → Descarga directa en navegador
```

---

## Consideraciones Técnicas

### Autenticación y Autorización
- **Asignación automática**: Todos los controladores de notas/documentos asignan automáticamente el profesional logueado     ////(TEMPORAL Automático)
- **Fallback**: Si no hay usuario logueado, se asigna el primer profesional activo
- **Sin selección manual**: Los formularios no incluyen selects de usuario (simplificación UX)

### Gestión de Archivos
- **Almacenamiento**: Archivos se guardan en el sistema de archivos (storage/app/public/documents/) con rutas almacenadas en BD
- **Metadatos**: Se almacenan nombre original, tamaño, tipo MIME, fecha de subida
- **Validación**: Máximo 10MB, tipos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG, TXT
- **Nombres únicos**: Se genera nombre único con timestamp para evitar conflictos

### Ordenación y Cronología
- **Notas y documentos**: Se ordenan por `created_at DESC` (más recientes primero)
- **Consistencia**: Mismo comportamiento en todas las entidades

### Mensajes y Feedback
- **Mensajes de éxito**: Confirmación de operaciones exitosas
- **Mensajes de error**: Validación y manejo de errores
- **Redirecciones**: Siempre redirigen a la vista show después de operaciones

---

## Patrones de Desarrollo

### 1. Patrón CRUD Estándar
Cada entidad sigue el patrón completo:
- **C**reate: `create()` + `store()`
- **R**ead: `index()` + `show()`
- **U**pdate: `edit()` + `update()`
- **D**elete: `destroy()`

### 2. Patrón de Notas/Documentos
Cada entidad principal tiene:
- Controladores específicos para notas y documentos
- Modelos con relaciones apropiadas
- Vistas con modales para interacción
- Rutas RESTful para operaciones

### 3. Patrón de Asignación Automática
- Usuario logueado se asigna automáticamente
- Fallback a primer profesional activo
- Sin intervención manual del usuario

### 4. Patrón de Respuesta Consistente
- Todas las operaciones redirigen con mensajes
- Mensajes en catalán para consistencia
- Manejo uniforme de errores y éxitos

---