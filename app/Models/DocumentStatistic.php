<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentStatistic extends Model
{
    protected $fillable = [
        'document_id',
        'views',
        'downloads',
        'stat_date',
    ];

    protected $casts = [
        'stat_date' => 'date',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
