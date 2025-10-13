<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class Professional extends Authenticatable
{
    protected $table = 'professionals';
    
    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'center_id',
        'role',
        'name',
        'surname1',
        'surname2',
        'dni',
        'phone',
        'email',
        'address',
        'employment_status',
        'cvitae',
        'user',       // username
        'password',   // contraseña hasheada
        'key_code',
        'status'
    ];

    /**
     * Mutator para hashear la contraseña automáticamente
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relaciones
    public function center() { return $this->belongsTo(Center::class); }
    public function materialAssignments() { return $this->hasMany(MaterialAssignment::class); }
    public function notes() { return $this->hasMany(ProfessionalNote::class); }
    public function documents() { return $this->hasMany(ProfessionalDocument::class); }
    public function createdNotes() { return $this->hasMany(ProfessionalNote::class, 'created_by_professional_id'); }
    public function uploadedDocuments() { return $this->hasMany(ProfessionalDocument::class, 'uploaded_by_professional_id'); }

    /**
     * Relación con el modelo User
     */
    public function userAccount()
    {
        return $this->hasOne(User::class, 'professional_id');
    }

    /**
     * Boot method: crea user automáticamente al crear professional
     * y borra user al eliminar professional
     */
    protected static function booted()
    {
        static::created(function ($professional) {
            // Preparar datos mínimos
            $userData = [
                'name' => $professional->name,
                'email' => $professional->email,
                'password' => $professional->password, // ya hasheada
            ];

            // Añadir 'user' solo si existe la columna en la tabla
            if (Schema::hasColumn('users', 'user')) {
                $userData['user'] = $professional->user;
            }

            // Crear user relacionado
            $professional->userAccount()->create($userData);
        });

        static::deleting(function ($professional) {
            if ($professional->userAccount) {
                $professional->userAccount->delete();
            }
        });
    }
}
