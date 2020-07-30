<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'Admin\HomeController@index')->name('home');
Route::get('/trash', 'TrashController@index')->name('trash');
Route::get('/trash/{$id}', 'TrashController@restore_product')->name('restore');
Route::get('/graph', 'GraphController@index')->name('graph');
Route::get('/graph/quantity', 'GraphController@quantity')->name('graph_quantity');
Route::resource('/products', 'ProductController');
