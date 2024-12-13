<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\RolesEnum;
use App\Models\Builders\UserBuilder;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'fcm_token',
        'provider_id',
        'provider',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'first_name',
        'last_name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** @return HasOne<Profile, $this> */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function newEloquentBuilder($query): UserBuilder //@phpstan-ignore-line
    {
        return new UserBuilder($query);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RolesEnum::Admin->value);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RolesEnum::SuperAdmin->value);
    }

    public function isMinistry(): bool
    {
        return $this->hasRole(RolesEnum::Ministry->value);
    }

    public function isArtiste(): bool
    {
        return $this->hasRole(RolesEnum::Artiste->value);
    }

    public function isMember(): bool
    {
        return $this->hasRole(RolesEnum::Member->value);
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(get: function (): string {
            if ($this->isArtiste() || $this->isMember()) {
                $arr = explode(' ', $this->name);
    
                return $arr[0];
            }
            return '';
        });
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(get: function (): string {
            if ($this->isArtiste() || $this->isMember()) {
                $arr = explode(' ', $this->name);
    
                return $arr[count($arr) - 1];
            }
            return '';
        });
    }
}
