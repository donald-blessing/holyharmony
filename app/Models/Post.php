<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FileCast;
use App\Http\Resources\PostResource;
use App\Models\Builders\PostBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'user_id',
        'views',
        'downloads',
        'is_downloadable',
        'upload',
    ];

    protected function casts(): array
    {
        return [
            'views'           => 'integer',
            'downloads'       => 'integer',
            'is_downloadable' => 'boolean',
            'upload'          => FileCast::class,
        ];
    }

    public static function trendingByCategory(): AnonymousResourceCollection
    {
        // Get the top category

        $posts = self::query()->select('category', DB::raw('SUM(views) as total_views'))
            ->groupBy('category') // Group posts by category
            ->latest('total_views') // Order by total views descending
            ->get();

        return PostResource::collection($posts);
    }

    public function newEloquentBuilder($query): PostBuilder //@phpstan-ignore-line
    {
        return new PostBuilder($query);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return HasMany<Review, $this> */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'post_id');
    }

    /** @return MorphMany<Like, $this> */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLikedByUser(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
