<?php

use App\Imports\AssistantUsersImport;
use App\Imports\EmployeeUsersImport;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/survey', 'survey')->name('survey');

Route::view('/users/create', 'users-create')->name('users.create');

Route::get('/users/import', function () {
    return view('users-import');
});

Route::post('/users/import', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'file' => 'required|file|mimes:xlsx',
    ]);

    $file = $request->file('file');

    Excel::import(new AssistantUsersImport, $file);

    return redirect()->back();

})->name('users.import');

Route::post('/users-employees/import', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'file' => 'required|file|mimes:xlsx',
    ]);

    $file = $request->file('file');

    Excel::import(new EmployeeUsersImport, $file);

    return redirect()->back();

})->name('users-employees.import');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
