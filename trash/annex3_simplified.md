# Proyecto 1 – Fundación Vallparadís

## Anexo 3 – Versión Simplificada: Arquitecturas y Tecnologías JavaScript para Clientes Web

### Contexto del Proyecto

El sistema de gestión de la Fundación Vallparadís es una aplicación web desarrollada con Laravel que permite administrar personal profesional y centros. Aunque actualmente el JavaScript implementado es mínimo, se ha establecido una base sólida para futuras funcionalidades interactivas.

---

## 1. Rol del JavaScript en el Proyecto

### Estado Actual
El JavaScript en este proyecto cumple un **rol fundamental pero básico**:

- **Infraestructura AJAX**: Biblioteca Axios configurada para peticiones HTTP asíncronas
- **Sistema de Compilación**: Vite para procesar y optimizar archivos CSS/JS
- **Preparación para Interactividad**: Base lista para implementar características del lado del cliente

### Funcionalidades Planificadas
- **Validaciones de Formularios**: Validación en tiempo real para formularios de Centros y Profesionales
- **Filtros Dinámicos**: Búsqueda y filtrado de tablas sin recargar la página
- **Modales Interactivos**: Confirmaciones de edición/eliminación usando componentes DaisyUI
- **Actualizaciones Dinámicas**: Desplegables en cascada (ej: selección de centro afecta roles disponibles)

### Justificación de la Interactividad del Cliente
El proyecto requiere JavaScript para:
1. **Mejorar la Experiencia de Usuario**: Interacciones fluidas sin recargas completas de página
2. **Validación en Tiempo Real**: Retroalimentación inmediata en entradas de formularios
3. **Gestión de Datos Complejos**: Manejo de grandes conjuntos de datos (profesionales, centros) con filtrado del lado del cliente
4. **Mejora Progresiva**: Construcción desde una base renderizada en el servidor

---

## 2. Arquitectura Utilizada (MVC + JavaScript)

### Integración JavaScript en Laravel MVC

```
Cliente (Navegador)              Servidor (Laravel)
┌─────────────────┐             ┌─────────────────┐
│   JavaScript    │  ──AJAX──▶  │   Controlador   │
│   (resources/js)│             │   (Capa HTTP)   │
└─────────────────┘             └─────────────────┘
         │                               │
         │                               ▼
         │                      ┌─────────────────┐
         │                      │      Modelo     │
         │                      │   (Base Datos)  │
         │                      └─────────────────┘
         │                               │
         ▼                               │
┌─────────────────┐                      │
│      Vista      │ ◀────────────────────┘
│ (Plantillas Blade)                     
└─────────────────┘
```

### Detalles de Implementación Actual

**Dónde se Ejecuta JavaScript:**
- **Navegador Cliente**: Compilado por Vite, cargado mediante `@vite('resources/js/app.js')`
- **Tiempo de Compilación**: Vite procesa y agrupa durante desarrollo/producción

**Comunicación con el Controlador:**
- **Configuración Axios**: Preparado para manejo de tokens CSRF (`X-Requested-With: XMLHttpRequest`)
- **Infraestructura Preparada**: Lista para endpoints API y envío de formularios

---

## 3. Tecnologías y Herramientas Elegidas

### Sistema de Compilación Vite

**Uso Actual:**
- **Compilación de Recursos**: Procesa `resources/js/app.js` y `resources/css/app.css`
- **Recarga en Caliente**: Actualizaciones en vivo durante desarrollo
- **Integración TailwindCSS**: Compila el framework CSS utility-first
- **Optimización de Producción**: Minificación y agrupación para despliegue

### Librerías JavaScript

**Axios (Cliente HTTP):**
- **Propósito**: Peticiones AJAX al backend Laravel
- **Configuración**: Manejo automático de tokens CSRF
- **Uso Futuro**: Envío de formularios, obtención de datos, comunicación API

**JavaScript Nativo:**
- **Enfoque Actual**: Implementación mínima de JavaScript vanilla
- **Razonamiento**: Evitar sobrecarga de frameworks para interacciones simples
- **Extensiones Futuras**: Manejo de eventos, manipulación DOM

### Gestión de Dependencias

**Dependencias Actuales:**
```json
{
  "devDependencies": {
    "axios": "^1.11.0",
    "vite": "^7.0.4",
    "tailwindcss": "^4.1.14",
    "daisyui": "^5.1.27"
  }
}
```

**Organización de Archivos:**
```
resources/
├── js/
│   ├── app.js          # Punto de entrada principal
│   └── bootstrap.js    # Configuración Axios
├── css/
│   └── app.css         # Importaciones TailwindCSS
└── views/              # Plantillas Blade con hooks JavaScript
```

---

## 4. Buenas Prácticas y Optimización

### Organización del Código

**Estructura Actual:**
- **Separación de Responsabilidades**: JavaScript en `resources/js`, estilos en `resources/css`
- **Enfoque Modular**: Configuración Bootstrap separada de la lógica principal de la aplicación
- **Integración Laravel**: Siguiendo convenciones Laravel para gestión de recursos

**Mejoras Planificadas:**
- **JavaScript Basado en Componentes**: Organizar por características (formularios, tablas, modales)
- **Módulos ES6**: Import/export para mejor organización del código
- **TypeScript**: Para implementaciones de características más grandes

### Rendimiento y Experiencia de Usuario

**Optimizaciones Actuales:**
- **HMR de Vite**: Retroalimentación rápida de desarrollo
- **Purga TailwindCSS**: Eliminar CSS no utilizado en producción
- **Minificación de Recursos**: Automática en compilaciones de producción

**Mejoras Planificadas:**
- **Carga Perezosa**: Cargar componentes JavaScript bajo demanda
- **Mejora Progresiva**: Asegurar funcionalidad sin JavaScript
- **Estados de Carga**: Retroalimentación visual para operaciones AJAX
- **Validación de Formularios**: Validación del lado del cliente con respaldo del servidor

---

## Estado Actual del Desarrollo

**Fase 1 (Actual)**: Configuración de Base ✅
- Sistema de compilación Vite configurado
- Infraestructura AJAX Axios lista
- Framework de estilos TailwindCSS + DaisyUI

**Fase 2 (Siguiente)**: Interactividad Básica 🔄
- Implementación de validación de formularios
- Envío de formularios AJAX
- Interacciones dinámicas de tablas

**Fase 3 (Futuro)**: Características Avanzadas 📋
- Actualizaciones de datos en tiempo real
- Filtrado y búsqueda complejos
- Panel de control con gráficos interactivos

---

**Fecha de Revisión:** Octubre 2025  
**Autor:** Equipo de Desarrollo  
**Institución:** Institut La Pineda – CFGS Desarrollo de Aplicaciones Web (2DAW ABP)  
**Licencia:** [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/deed.es)
