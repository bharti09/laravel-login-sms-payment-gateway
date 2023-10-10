<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RazorpayController;

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

Route::get('/welcome2', 'HomeController@show');
Route::post('/welcome2', 'HomeController@storePhoneNumber');
Route::post('/custom', 'HomeController@sendCustomMessage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::patch('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification',[HomeController::class,'notification'])->name('notification');

Route::get('/input_component',[HomeController::class,'input']);
Route::post('/customers',[HomeController::class,'store'])->name('customers');
Route::get('/customers/index',[HomeController::class,'customerIndex']);
Route::get('/customer/edit/{id}',[HomeController::class,'customerEdit']);
Route::post('/customer/update/{id}',[HomeController::class,'customerUpdate']);
Route::get('/customer/delete/{id}',[HomeController::class,'customerDestroy']);


Route::get('/user',function(){
    return 'user route';
});


Route::get('/user/test',[TestController::class,'index'])->name('test');

Route::get('/user/edit/{id?}', function($id){
    //print_r('jhghjdgj');
    echo $id;
});

//Razorpay integration
Route::get('payment',[RazorpayController::class,'index']);
Route::post('razorpay-payment',[RazorpayController::class,'store'])->name('razorpay.payment.store');