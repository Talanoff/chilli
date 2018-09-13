<?php

namespace App\Models\Meta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Meta extends Model
{
    protected $fillable = [
        'metable_id',
        'metable_type',
        'title',
        'description',
        'keywords',
    ];

    /**
     * @return MorphTo
     */
    public function metable(): MorphTo
    {
        return $this->morphTo();
    }
}
