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

// Broadcast::channel('OrderCreated.{id}', function ($user, $id) {
//     return true;
// });
Broadcast::channel('OrderCreated.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('OrderCreated.Company.{id}', function ($company, $id) {
    return (int) $company->id === (int) $id;
});
