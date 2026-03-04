<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SweetSpotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/language/{locale}', function ($locale) {
    $supportedLocales = ['en', 'es', 'fr', 'de', 'zh', 'ar', 'hi', 'pt', 'ru', 'ja'];
    if (in_array($locale, $supportedLocales)) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Documentation Route (Public)
Route::get('/docs', function () {
    $locale = session('locale', config('app.locale'));
    $path = base_path("docs/{$locale}.md");
    if (!file_exists($path)) {
        $path = base_path("docs/en.md");
    }
    $content = file_get_contents($path);
    return view('docs', ['content' => \Illuminate\Support\Str::markdown($content)]);
})->name('docs');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('dashboard.sweetspot');
    })->name('dashboard');

    // Sweet Spot Routes
    Route::get('dashboard/sweetspot', [DashboardController::class, 'index'])->name('dashboard.sweetspot');
    Route::resource('customers', CustomerController::class);
    Route::get('settings/weights', [SettingsController::class, 'index'])->name('settings.weights.index');
    Route::get('sweetspot/calculate', [SweetSpotController::class, 'calculate'])->name('sweetspot.calculate');

    // Team Routes
    \Livewire\Volt\Volt::route('/team', 'team-management')->name('team.index');
    \Livewire\Volt\Volt::route('/roles', 'role-management')->name('roles.index');

    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
