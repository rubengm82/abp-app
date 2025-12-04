<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentComponent extends Model
{
    protected $table = 'documents_component';

    protected $fillable = [
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_by_professional_id',
        'document_type'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Polymorphic relation to any model (Center, ProjectCommission, etc.)
     */
    public function documentable()
    {
        return $this->morphTo();
    }

    /**
     * Professional that uploaded the document
     */
    public function uploadedByProfessional()
    {
        return $this->belongsTo(Professional::class, 'uploaded_by_professional_id');
    }

    /**
     * Get the formatted origin of the document
     */
    public function getOriginAttribute()
    {
        if (!$this->documentable) {
            return 'Desconocido';
        }

        $model = $this->documentable;
        $type = class_basename($model);

        switch ($type) {
            case 'Center':
                return "Centro: {$model->name}";
            case 'Professional':
                return "Profesional: {$model->name} {$model->surname1}";
            case 'ProjectCommission':
                return "Proyecto: {$model->name}";
            case 'Course':
                return "Curso: {$model->name}";
            case 'GeneralService':
                return "Servicio General: {$model->service_type}";
            case 'ComplementaryService':
                return "Servicio Complementario: {$model->service_type}";
            case 'HrIssue':
                return "Incidencia RRHH: {$model->issue_type}";
            case 'Maintenance':
                return "Mantenimiento: {$model->maintenance_type}";
            case 'MaterialAssignment':
                return "Asignación Material: {$model->material_type}";
            case 'ExternalContact':
                return "Contacto Externo: {$model->name}";
            default:
                return "{$type}: " . ($model->name ?: 'Sin nombre');
        }
    }

    /**
     * Get the URL to the origin's show page
     */
    public function getOriginUrlAttribute()
    {
        if (!$this->documentable) {
            return null;
        }

        $model = $this->documentable;
        $type = class_basename($model);

        switch ($type) {
            case 'Center':
                return route('center_show', $model->id);
            case 'Professional':
                return route('professional_show', $model->id);
            case 'ProjectCommission':
                return route('projectcommission_show', $model);
            case 'Course':
                return route('course_show', $model);
            case 'GeneralService':
                return route('general_service_show', $model->service_type);
            case 'ComplementaryService':
                return route('complementaryservice_show', $model);
            case 'HrIssue':
                return route('hr_issue_show', $model->id);
            case 'Maintenance':
                return route('maintenance_show', $model);
            case 'MaterialAssignment':
                return route('materialassignment_show', $model);
            case 'ExternalContact':
                return route('externalcontact_show', $model);
            default:
                return null;
        }
    }
}
