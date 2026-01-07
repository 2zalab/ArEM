<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'arem_doc_id',
        'user_id',
        'department_id',
        'document_type_id',
        'title',
        'abstract',
        'keywords',
        'language',
        'year',
        'academic_year',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'access_rights',
        'embargo_date',
        'status',
        'validated_by',
        'validated_at',
        'published_at',
        'permanent_url',
        'doi',
    ];

    protected $casts = [
        'keywords' => 'array',
        'validated_at' => 'datetime',
        'published_at' => 'datetime',
        'embargo_date' => 'date',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function metadata()
    {
        return $this->hasMany(DocumentMetadata::class);
    }

    public function validationWorkflows()
    {
        return $this->hasMany(ValidationWorkflow::class);
    }

    public function statistics()
    {
        return $this->hasMany(DocumentStatistic::class);
    }

    /**
     * Helpers
     */
    public function getMetaValue($key)
    {
        $meta = $this->metadata()->where('meta_key', $key)->first();
        return $meta ? $meta->meta_value : null;
    }

    public function setMetaValue($key, $value)
    {
        return $this->metadata()->updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    public function getTotalViews()
    {
        return $this->statistics()->sum('views');
    }

    public function getTotalDownloads()
    {
        return $this->statistics()->sum('downloads');
    }

    public function incrementViews()
    {
        $today = now()->format('Y-m-d');
        $stat = $this->statistics()->firstOrCreate(['stat_date' => $today]);
        $stat->increment('views');
    }

    public function incrementDownloads()
    {
        $today = now()->format('Y-m-d');
        $stat = $this->statistics()->firstOrCreate(['stat_date' => $today]);
        $stat->increment('downloads');
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isValidated()
    {
        return $this->status === 'validated';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccessible()
    {
        if ($this->access_rights === 'public') {
            return true;
        }

        if ($this->access_rights === 'embargo' && $this->embargo_date) {
            return now()->greaterThan($this->embargo_date);
        }

        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (!$document->arem_doc_id) {
                $document->arem_doc_id = 'AREM-DOC-ENS-' . date('Y') . '-' . str_pad(static::max('id') + 1, 5, '0', STR_PAD_LEFT);
            }

            if (!$document->permanent_url) {
                $document->permanent_url = url('/documents/' . $document->arem_doc_id);
            }
        });
    }
}
