<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FileCast;
use App\Casts\JsonCast;
use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'stage_name',
        'photo',
        'genre',
        'preferred_performance_location',
        'bio',
        'phone',
        'address',
        'special_skills',
        'interests',
        'social_media',
        'user_id',
        'date_of_birth',
        'gender',
        'ministry_id',
    ];

    protected $primaryKey = 'uuid';

    protected function stageName(): Attribute
    {
        return Attribute::make(set: function (string $value): string {
            return $value !== '' && $value !== '0' ? $value : $this->user->name;
        });
    }

    protected function casts(): array
    {
        return [
            'photo'          => FileCast::class,
            'genre'          => JsonCast::class,
            'address'        => JsonCast::class,
            'special_skills' => JsonCast::class,
            'interests'      => JsonCast::class,
            'social_media'   => JsonCast::class,
            'user_id'        => 'integer',
            'ministry_id'    => 'integer',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return BelongsTo<User, $this> */
    public function ministry(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ministry_id');
    }
}
