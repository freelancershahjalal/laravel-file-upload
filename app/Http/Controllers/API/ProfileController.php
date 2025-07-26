<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Base\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProfileController extends BaseApiController
{
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        if (isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        // Optionally, you can clear the cache for the user profile if caching is implemented
        $cacheKey = "user_profile_{$user->id}";
        Cache::put($cacheKey, new UserResource($user), now()->addHour(1));
//        logger($data);
        return $this->success(new UserResource($user), 'Profile updated successfully');
    }
}
