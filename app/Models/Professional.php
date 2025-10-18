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
        'password',   // hashed password
        'key_code',
        'status'
    ];

    /**
     * Mutator to automatically hash the password
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relationships
    public function center() { return $this->belongsTo(Center::class); }
    public function materialAssignments() { return $this->hasMany(MaterialAssignment::class); }
    public function notes() { return $this->hasMany(ProfessionalNote::class); }
    public function documents() { return $this->hasMany(ProfessionalDocument::class); }
    public function createdNotes() { return $this->hasMany(ProfessionalNote::class, 'created_by_professional_id'); }
    public function uploadedByProfessional() { return $this->hasMany(ProfessionalDocument::class, 'uploaded_by_professional_id'); }

    /**
     * Relationship with the user model
     */
    public function userAccount()
    {
        return $this->hasOne(User::class, 'professional_id');
    }

    /**
     * Boot method: automatically creates user when creating professional
     * and deletes user when deleting professional
     */
    protected static function booted()
    {
        static::created(function ($professional) {
            // Prepare minimum data
            $userData = [
                'name' => $professional->name,
                'email' => $professional->email,
                'password' => $professional->password, // ya hasheada
            ];

            // Add 'user' only if the column exists in the table
            if (Schema::hasColumn('users', 'user')) {
                $userData['user'] = $professional->user;
            }

            // Create related user
            $professional->userAccount()->create($userData);
        });

        static::deleting(function ($professional) {
            if ($professional->userAccount) {
                $professional->userAccount->delete();
            }
        });
    }
}
