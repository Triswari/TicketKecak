<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CalculationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddTicketsController;
use App\Http\Controllers\AdditionalsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestoreController;
use App\Http\Controllers\AccessCodeController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccessCodeMail;
use App\Models\AccessCode;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\GoogleController;


// Redirect to dashboard with auth middleware
Route::get('/', function () { return redirect('/dashboard'); })->middleware('auth');

// Registration routes
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name("register");
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name("register.perform");

// Set Role
Route::post('/users/{id}/set-role', [UserController::class, 'setRole'])->name('users.setRole');

Route::get('/send-test-email', [TestEmailController::class, 'sendTestEmail']);

// Login routes
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name("login");
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name("login.perform");

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallBack']);


// Password reset routes
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name("reset-password");
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name("reset.perform");
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name("change-password");
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name("change.perform");

// Dashboard route
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');


// Export routes
Route::get('bookings/export', [BookingController::class, 'export_excel']);
Route::get('reports/export', [ReportController::class, 'export_excel']);

// admin
Route::group(['middleware' => ['auth', 'role:super_admin,admin']], function () {

    Route::post('/dashboard', [HomeController::class, 'hitung'])->name('dashboard.hitung');
    
    // Calculation routes

    Route::get('/calculation', [CalculationController::class, 'index'])->name('calculation.index');
    Route::post('/calculation', [CalculationController::class, 'calculate'])->name('calculation.calculate');

    // User management routes

    Route::post('/validate-password', [UserController::class, 'validatePassword'])->name('validate.password');
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
    Route::post('/update-role/{id}', [UserController::class, 'updateRole'])->name('updateRole');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('editUser');

    Route::post('/send-request', [RequestController::class, 'sendRequest'])->name('send.request');

    // code access routes
    Route::post('/access-codes', [AccessCodeController::class, 'store'])->name('access-codes.store');
    
    // Booking routes
    Route::get('/bookings', [BookingController::class, 'booking'])->name('bookings');
    Route::get('/tickets', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/tickets', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/get-name-price-add/{id}', [BookingController::class, 'getNamePriceAdd']);
    Route::get('/get-title-price-ticket/{id}', [BookingController::class, 'getTitlePriceTicket']);


    // Products routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/addticket/create', [AddTicketsController::class, 'create'])->name('addtickets.create');
    Route::post('/addticket', [AddTicketsController::class, 'store'])->name('addtickets.store');
    Route::get('/addticket/{id}/edit', [AddTicketsController::class, 'edit'])->name('addtickets.edit');
    Route::put('/addticket/{id}', [AddTicketsController::class, 'update'])->name('addtickets.update');
    Route::delete('/addticket/{id}', [AddTicketsController::class, 'destroy'])->name('addtickets.destroy');

    Route::get('/additionals/create', [AdditionalsController::class, 'create'])->name('additionals.create');
    Route::post('/additionals', [AdditionalsController::class, 'store'])->name('additionals.store');
    Route::get('/additionals/{id}/edit', [AdditionalsController::class, 'edit'])->name('additionals.edit');
    Route::put('/additionals/{id}', [AdditionalsController::class, 'update'])->name('additionals.update');
    Route::delete('/additionals/{id}', [AdditionalsController::class, 'destroy'])->name('additionals.destroy');
    
    // Edit routes
    Route::get('/edit/{id}', [EditController::class, 'read'])->name('edit.read');
    Route::post('/update/{id}', [EditController::class, 'update'])->name('edit.update');
    Route::post('/delete/{id}', [EditController::class, 'delete'])->name('edit.delete');
    Route::get('/get-name-price-add/{id}', [EditController::class, 'getNamePriceAdd']);
    Route::get('/get-title-price-ticket/{id}', [EditController::class, 'getTitlePriceTicket']);

    // Invoice routes
    Route::get('/invoice/{id}', [InvoiceController::class, 'show']);
});

// super admin
Route::group(['middleware' => ['auth', 'role:super_admin']], function () {


    // User management routes

    Route::get('/user-management', [UserController::class, 'index'])->name('user-management');
    Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
    Route::post('/update-role/{id}', [UserController::class, 'updateRole'])->name('updateRole');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('editUser');

    

    // code access routes
    Route::post('/access-codes', [AccessCodeController::class, 'store'])->name('access-codes.store');
    

    // Restore routes

    Route::get('/restore', [RestoreController::class, 'index'])->name('restore.index');
    Route::post('/tickets/{id_ticket}/restore', [RestoreController::class, 'restoreTicket'])->name('tickets.restore');
    Route::post('/add/{id_add}/restore', [RestoreController::class, 'restoreAdd'])->name('add.restore');
    Route::post('/booking/{id_booking}/restore', [RestoreController::class, 'restoreBookings'])->name('booking.restore');
    Route::post('/user/{id}/restore', [RestoreController::class, 'restoreUser'])->name('user.restore');
    
});

// auth route
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/profile', [UserProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('/send-request', [RequestController::class, 'sendRequest'])->name('send.request')->middleware('auth');
Route::get('/notification', [NotificationController::class, 'notif'])->name('notifications.notif')->middleware('auth');
Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware('auth');
// Report routes
Route::get('/reports', [ReportController::class, 'report'])->name('reports')->middleware('auth');
Route::get('reports/export', [ReportController::class, 'export_excel'])->middleware('auth');
// chart routes
Route::get('/visitor-data', [BookingController::class, 'getVisitorData'])->name('visitor-data')->middleware('auth');


