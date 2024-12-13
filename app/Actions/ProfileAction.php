<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\ProfileData;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Traits\Helper;
use Illuminate\Support\Facades\DB;

class ProfileAction
{
    use Helper;

    public static function handle(ProfileData $profileData): ProfileResource
    {
        return DB::transaction(function () use ($profileData): ProfileResource {
            if (isset($profileData->role)) {
                AssignRoleAction::handle($profileData->user, $profileData->role);
            }

            $data = self::removeEmptyElements($profileData->toArray());

            $profile = Profile::query()->updateOrCreate($profileData->only('user_id')->toArray(), $data);

            return new ProfileResource($profile->fresh());
        });
    }
}
