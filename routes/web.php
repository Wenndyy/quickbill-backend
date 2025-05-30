<?php

use App\Http\Controllers\Api\ForgotPasswordOtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
    return Auth::check() ? redirect()->route('home') : view('pages.landing-page');
});

Route::get('/register', function(){
    return view('pages.auth.register');
})->name('register');

Route::post('/registration', [RegisterController::class, 'store'])->name('registration');


Route::middleware(['auth'])->group(function () {
    Route::get('home', [\App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::resource('user', UserController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});




Route::get('/forgot-password-otp', [ForgotPasswordOtpController::class, 'showRequestForm'])->name('forgot.otp.form');
Route::post('/forgot-password-otp', [ForgotPasswordOtpController::class, 'sendOtp'])->name('forgot.otp.send');

Route::get('/input-otp', [ForgotPasswordOtpController::class, 'showOtpForm'])->name('forgot.otp.input');
Route::post('/verify-otp', [ForgotPasswordOtpController::class, 'verifyOtp'])->name('forgot.otp.verify');

Route::get('/reset-password-form', [ForgotPasswordOtpController::class, 'showResetForm'])->name('forgot.password.form');
Route::post('/reset-password-form', [ForgotPasswordOtpController::class, 'resetPassword'])->name('forgot.password.reset');
