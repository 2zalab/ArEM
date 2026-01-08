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
        'authors',
        'citation',
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
        'authors' => 'array',
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
        $stat = $this->statistics()->updateOrCreate(
            [
                'document_id' => $this->id,
                'stat_date' => $today
            ],
            [
                'views' => 0,
                'downloads' => 0
            ]
        );
        $stat->increment('views');
        return $stat;
    }

    public function incrementDownloads()
    {
        $today = now()->format('Y-m-d');
        $stat = $this->statistics()->updateOrCreate(
            [
                'document_id' => $this->id,
                'stat_date' => $today
            ],
            [
                'views' => 0,
                'downloads' => 0
            ]
        );
        $stat->increment('downloads');
        return $stat;
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

    public function generateCitation()
    {
        if (!$this->authors || count($this->authors) === 0) {
            return null;
        }

        $citation = '';

        // Format des auteurs
        $authors = [];
        foreach ($this->authors as $author) {
            $name = $author['name'] ?? '';
            if ($name) {
                // Format: Nom, Initiale.
                $nameParts = explode(' ', trim($name));
                if (count($nameParts) > 1) {
                    $lastName = array_pop($nameParts);
                    $initials = implode('. ', array_map(fn($n) => substr($n, 0, 1), $nameParts)) . '.';
                    $authors[] = $lastName . ', ' . $initials;
                } else {
                    $authors[] = $name;
                }
            }
        }

        if (count($authors) === 1) {
            $citation .= $authors[0];
        } elseif (count($authors) === 2) {
            $citation .= $authors[0] . ' & ' . $authors[1];
        } elseif (count($authors) > 2) {
            $citation .= $authors[0] . ' et al.';
        }

        // Année
        $citation .= ' (' . ($this->year ?? date('Y')) . '). ';

        // Titre
        $citation .= $this->title . '. ';

        // Informations spécifiques selon le type
        if ($this->documentType && $this->metadata) {
            $type = $this->documentType->code;
            $meta = $this->metadata;

            // Article scientifique
            if ($type === 'article' && isset($meta['journal'])) {
                $citation .= '<em>' . $meta['journal'] . '</em>';

                if (isset($meta['volume'])) {
                    $citation .= ', <em>' . $meta['volume'] . '</em>';
                }

                if (isset($meta['issue'])) {
                    $citation .= '(' . $meta['issue'] . ')';
                }

                if (isset($meta['pages'])) {
                    $citation .= ', ' . $meta['pages'];
                }

                $citation .= '. ';

                if (isset($meta['doi'])) {
                    $citation .= 'https://doi.org/' . $meta['doi'];
                }
            }
            // Mémoire/Thèse
            elseif (in_array($type, ['memoire_licence', 'memoire_master', 'these_doctorat', 'memoire_dipes_ii'])) {
                $citation .= '[' . $this->documentType->name . ']. ';
                $citation .= 'École Normale Supérieure de Maroua. ';
            }
            // Autres types
            else {
                $citation .= $this->documentType->name . '. ';
            }
        }

        // Institution
        $citation .= 'Archive ArEM-ENS Maroua. ';

        // URL permanente
        if ($this->permanent_url) {
            $citation .= $this->permanent_url;
        }

        return $citation;
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

            // Générer la citation automatiquement
            if (!$document->citation) {
                $document->citation = $document->generateCitation();
            }
        });

        static::updating(function ($document) {
            // Régénérer la citation si les auteurs ou métadonnées changent
            if ($document->isDirty(['authors', 'title', 'year'])) {
                $document->citation = $document->generateCitation();
            }
        });
    }
}
