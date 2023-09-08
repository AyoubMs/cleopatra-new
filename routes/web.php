<?php

use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use \Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/tenant', function () {
        return view('tenant')->with('tenants', Tenant::all());
    })->name('tenant');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/members', function () {
        return view('members');
    })->name('members');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('azure')->redirect();
});

Route::get('azuread/auth/callback', function () {
    $azureUser = Socialite::driver('azure')->user();

    $user = User::firstOrCreate(
        [
            'email' => $azureUser->getEmail(),
            'name' => $azureUser->getName(),
        ]
    );

    $user->provider_id = $azureUser->getId();

    if(is_null($user->currentTeam)) {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }

    // $user->token

    // Log the user in
    auth()->login($user, true);

    if($user->tenant_id !== null) {
        return redirect('dashboard');
    } else {
        return redirect('tenant');
    }
});
