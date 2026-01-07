<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentMetadata extends Model
{
    protected $fillable = [
        'document_id',
        'meta_key',
        'meta_value',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
