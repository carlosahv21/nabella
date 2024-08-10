<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Billing;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ExampleLaravel\UserManagement;
use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Drivers;

use App\Http\Livewire\Tables;
use App\Http\Livewire\Vehicles;
use App\Http\Livewire\Patients;
use App\Http\Livewire\Facilities;
use App\Http\Livewire\Schedulings;
use App\Http\Livewire\ServiceContracts;

use App\Http\Livewire\Calendar;
use App\Http\Livewire\Dash;
use App\Http\Livewire\Reports;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;

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

Route::get('user-profile', UserProfile::class)->middleware('can:user.view')->name('user-profile');

Route::get('role', Roles::class)->middleware('can:role.view')->name('role');
Route::get('show', [Roles::class, 'show']);

Route::get('driver', Drivers::class)->middleware('can:driver.view')->name('driver');

Route::get('vehicle', Vehicles::class)->middleware('can:vehicle.view')->name('vehicle');

Route::get('servicecontract', ServiceContracts::class)->middleware('can:servicecontract.view')->name('servicecontract');

Route::get('patient', Patients::class)->middleware('can:patient.view')->name('patient');

Route::get('facility', Facilities::class)->middleware('auth')->name('facility');

Route::get('scheduling', Schedulings::class)->middleware('auth')->name('scheduling');

Route::get('user-management', UserManagement::class)->middleware('auth')->name('user-management');

Route::get('calendar', Calendar::class)->middleware('auth')->name('calendar');

Route::get('reports', Reports::class)->middleware('auth')->name('reports');


Route::get('pdf', function () {
    $schedulings = DB::table('schedulings')->get();
    $service_contract = DB::table('service_contracts')->get()->first();

    $total = 0;
    foreach ($schedulings as $scheduling) {
        $patient = DB::table('patients')->where('id', $scheduling->patient_id)->get()->first();
        $scheduling->patient_name = $patient->first_name . ' ' . $patient->last_name;
        $scheduling->description = getDescription($scheduling);

        $service_contract = DB::table('service_contracts')->get()->first();
        $scheduling->amount = explode(' ', $scheduling->distance)[0] * $service_contract->rate_per_mile;

        $total = $total + $scheduling->amount;
    }
    return view('livewire.report.pdf', [
        'data' => $schedulings,
        'service_contract' => $service_contract,
        'total' => $total
    ]);

        // Pdf::view('livewire.report.pdf', [
        //     'data' => $schedulings,
        //     'service_contract' => $service_contract,
        //     'total' => $total
        // ])->save('new.pdf');
});

Route::get('pdf_d', function () {
    $name = 'pdfs/' . time() . 'invoice.pdf';
    Pdf::view('livewire.report.pdf_d', [
        'invoiceNumber' => '1234',
        'customerName' => 'Grumpy Cat',
        
    ])
    ->setOption('args', ['--no-sandbox', '--disable-crash-reporter'])
    ->save($name);

    return 'Success!';
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', Dash::class)->name('dashboard');
    Route::get('billing', Billing::class)->name('billing');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('tables', Tables::class)->name('tables');
    Route::get('notifications', Notifications::class)->name("notifications");
});
