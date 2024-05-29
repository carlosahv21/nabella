<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Billing;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ExampleLaravel\UserManagement;
use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Drivers;
use App\Http\Livewire\RTL;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Tables;
use App\Http\Livewire\Vehicles;
use App\Http\Livewire\Clients;
use App\Http\Livewire\Patients;
use App\Http\Livewire\Hospitals;
use App\Http\Livewire\Schedulings;
use App\Http\Livewire\ServiceContracts;
use App\Http\Livewire\VirtualReality;
use GuzzleHttp\Middleware;

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

Route::get('/', function(){
    return redirect('sign-in');
});

Route::get('forgot-password', ForgotPassword::class)->middleware('guest')->name('password.forgot');
Route::get('reset-password/{id}', ResetPassword::class)->middleware('signed')->name('reset-password');



Route::get('sign-up', Register::class)->middleware('guest')->name('register');
Route::get('sign-in', Login::class)->middleware('guest')->name('login');

Route::get('user-profile', UserProfile::class)->middleware('can:user.view')->name('user-profile');

Route::get('role', Roles::class)->middleware('can:role.view')->name('role');
Route::get('show', [Roles::class, 'show']);

Route::get('driver', Drivers::class)->middleware('can:driver.view')->name('driver');

Route::get('vehicle', Vehicles::class)->middleware('can:vehicle.view')->name('vehicle');

Route::get('servicecontract', ServiceContracts::class)->middleware('can:servicecontract.view')->name('servicecontract');

Route::get('patient', Patients::class)->middleware('can:patient.view')->name('patient');

Route::get('hospital', Hospitals::class)->middleware('auth')->name('hospital');

Route::get('scheduling', Schedulings::class)->middleware('auth')->name('scheduling');

Route::get('user-management', UserManagement::class)->middleware('auth')->name('user-management');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('billing', Billing::class)->name('billing');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('tables', Tables::class)->name('tables');
    Route::get('notifications', Notifications::class)->name("notifications");
});