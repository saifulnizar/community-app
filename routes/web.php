<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Http\Livewire\PostCreate;
use App\Http\Livewire\PostIndex;

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAdmin;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified', RedirectIfAdmin::class])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/posts', 'posts.index')->middleware(['auth'])->name('posts.index');
});


require __DIR__.'/auth.php';
