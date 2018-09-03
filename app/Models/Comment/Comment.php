<?php

namespace App\Models\Comment;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $fillable = [
        'status',
        'message',
        'user_id',
    ];

    protected $with = [
        'user',
    ];

    public static $STATUSES = [
        'agreement' => 'На согласовании',
        'approved' => 'Утвержден',
        'declined' => 'Отклонен',
    ];

    /**
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
