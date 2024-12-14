<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\InterestsData;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Traits\Helper;
use Illuminate\Support\Facades\DB;

class InterestsAction
{
    use Helper;

    public static function handle(InterestsData $interestsData): ProfileResource
    {
        return DB::transaction(function () use ($interestsData): ProfileResource {
            $data = self::removeEmptyElements($interestsData->toArray());

            $interest = Profile::query()->updateOrCreate($interestsData->only('user_id')->toArray(), $data);

            return new ProfileResource($interest->fresh());
        });
    }
}
