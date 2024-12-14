<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    /** @use HasFactory<ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'body',
        'review_id',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return HasMany<\App\Models\Review, $this>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'review_id');
    }

    /**
     * @return BelongsTo<\App\Models\Review, $this>
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(self::class, 'review_id');
    }
}
