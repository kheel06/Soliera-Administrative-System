<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('user.{userId}', function ($user, $userId) {
    // Support both User and DeptAccount models
    $userIdValue = $user->id ?? $user->Dept_no ?? null;
    return $userIdValue && (int) $userIdValue === (int) $userId;
});
