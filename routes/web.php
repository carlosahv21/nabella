<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Logout;

use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Drivers;
use App\Http\Livewire\Vehicles;
use App\Http\Livewire\Patients;
use App\Http\Livewire\Facilities;
use App\Http\Livewire\Schedulings;
use App\Http\Livewire\ServiceContracts;


use App\Http\Livewire\Dash;
use App\Http\Livewire\Reports;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('sign-in');
});

Route::get('forgot-password', ForgotPassword::class)->middleware('guest')->name('password.forgot');
Route::get('reset-password/{id}', ResetPassword::class)->middleware('signed')->name('reset-password');

Route::get('sign-up', Register::class)->middleware('guest')->name('register');
Route::get('sign-in', Login::class)->middleware('guest')->name('login');

Route::get('download', function () {
    // Ruta dentro de storage
    $filePath = storage_path('dump_production.sql');

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        echo 'error', 'El archivo de dump no se encuentra.';
    }
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('user-profile', UserProfile::class)->middleware('can:user.view')->name('user-profile');
    Route::get('role', Roles::class)->middleware('can:role.view')->name('role');
    Route::get('driver', Drivers::class)->middleware('can:driver.view')->name('driver');
    Route::get('vehicle', Vehicles::class)->middleware('can:vehicle.view')->name('vehicle');
    Route::get('servicecontract', ServiceContracts::class)->middleware('can:servicecontract.view')->name('servicecontract');
    Route::get('patient', Patients::class)->middleware('can:patient.view')->name('patient');
    Route::get('facility', Facilities::class)->middleware('can:facility.view')->name('facility');
    Route::get('scheduling', Schedulings::class)->middleware('can:scheduling.view')->name('scheduling');
    Route::get('reports', Reports::class)->middleware('can:report.view')->name('reports');
    Route::get('dashboard', Dash::class)->name('dashboard');
    Route::get('profile/{id}', Profile::class)->name('profile');
    Route::get('destroy', Logout::class)->name('destroy');
});
