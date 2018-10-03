<?php

namespace App\Models\Page;

use App\Models\Meta\Meta;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Page extends Model
{
    use Slugable;

    protected $fillable = [
        'title',
        'body',
        'params',
    ];

    protected $casts = [
        'params' => 'array',
    ];

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }
}
