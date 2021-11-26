<?php

use App\Models\Check;
use Illuminate\Support\Facades\Route;

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

Route::post('/registration','App\Http\Controllers\AuthController@registration')->name('registration');
Route::post('/login',   'App\Http\Controllers\AuthController@login')->name('login');

Route::get('/', function () {
    $checks = Check::paginate(8);
    return view('main',[
        'checks' => $checks
    ]);
})->name('main')->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/registration', function () {
    return view('auth.registration');
});
