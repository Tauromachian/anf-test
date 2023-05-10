<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\LineController;
use App\Models\Line;
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


Route::get('home', function () {
    $lines = Line::withCount('clients')->orderBy('clients_count', 'desc')->paginate(10);
    return view('home', compact('lines'));
})->name('home');