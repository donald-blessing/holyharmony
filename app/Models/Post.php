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

    protected $casts = [
        'views'           => 'integer',
        'downloads'       => 'integer',
        'is_downloadable' => 'boolean',
        'upload'          => FileCast::class,
    ];

    public static function trendingByCategory(): AnonymousResourceCollection
    {
        // Get the top category

        $posts = self::query()->select('category', DB::raw('SUM(views) as total_views'))
            ->groupBy('category') // Group posts by category
            ->orderByDesc('total_views') // Order by total views descending
            ->get();

        return PostResource::collection($posts);
    }

    public function newEloquentBuilder($query): PostBuilder //@phpstan-ignore-line
    {
        return new PostBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'post_id');
    }
}
