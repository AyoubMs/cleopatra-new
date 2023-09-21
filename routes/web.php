<?php

use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Response;
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
    return redirect('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/templates', function() {
        if (auth()->user()->role !== null && !(auth()->user()->role->name === 'admin' or auth()->user()->role->name === 'supervisor')) {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('templates.index');
    });

    Route::get('/users', function() {
        if (auth()->user()->role !== null && !(auth()->user()->role->name === 'admin' or auth()->user()->role->name === 'supervisor')) {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('users.index');
    });
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
    $user = User::where(['email' => $azureUser->getEmail()])->first();
    if ($user === null) {
        $user = User::firstOrCreate(
            [
                'email' => $azureUser->getEmail(),
                'name' => $azureUser->getName(),
            ]
        );
    }
    $user->provider_id = $azureUser->getId();

    // $user->token

    // Log the user in
    auth()->login($user, true);

    if($user->tenant_id !== null) {
        return redirect('dashboard');
    } else {
        return redirect('tenant');
    }
});
