<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'arem_id',
        'role',
        'department_id',
        'status',
        'filiere',
        'institutional_email',
        'phone',
        'profile_photo',
        'institution',
        'user_type',
        'grade',
        'education_level',
        'bio',
        'research_interests',
        'is_active',
        // CV fields
        'birth_date',
        'birth_place',
        'nationality',
        'address',
        'linkedin',
        'orcid',
        'google_scholar',
        'education',
        'experience',
        'skills',
        'languages',
        'publications',
        'certifications',
        'references',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'birth_date' => 'date',
            'education' => 'array',
            'experience' => 'array',
            'skills' => 'array',
            'languages' => 'array',
            'publications' => 'array',
            'certifications' => 'array',
            'references' => 'array',
        ];
    }

    /**
     * Relations
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function validatedDocuments()
    {
        return $this->hasMany(Document::class, 'validated_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function validationWorkflows()
    {
        return $this->hasMany(ValidationWorkflow::class);
    }

    /**
     * Helpers
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    public function isDepositor()
    {
        return $this->role === 'depositor';
    }

    public function canValidateDocuments()
    {
        return in_array($this->role, ['admin', 'moderator']);
    }

    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->arem_id) {
                $user->arem_id = 'AREM-AUTH-' . date('Y') . '-' . str_pad(static::max('id') + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
