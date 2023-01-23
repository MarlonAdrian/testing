<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\ProductOwnerController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\Rules\Password;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisteredUserController::class, 'register']);
Route::get('/showproducts', [ClientController::class, 'showproducts']);
Route::get('/feedbacks', [FeedbackController::class, 'feedbacks']);


/*-----------------------ADMIN-----------------------*/
/*Users*/
Route::get('/indexUsers', [AdminController::class, 'indexUsers']);
Route::get('/showUser/{id}', [AdminController::class, 'showUser']);
Route::delete('/destroyUser/{id}', [AdminController::class, 'destroyUser']);
/*Commerces*/
Route::get('/indexCommerces', [AdminController::class, 'indexCommerces']);
Route::get('/showCommerce/{id}', [AdminController::class, 'showCommerce']);
Route::delete('/destroyCommerce/{id}', [AdminController::class, 'destroyCommerce']);
/*Product */
Route::get('/indexProducts', [AdminController::class, 'indexProducts']);
Route::get('/showaProduct/{id}', [AdminController::class, 'showaProduct']);
/*Feedback */
Route::get('/showFeedback/{id}', [AdminController::class, 'showFeedback']);

/*-------------------PRODUCT OWNER-------------------*/
Route::get('/publishedProducts', [ProductOwnerController::class, 'publishedProducts']);
Route::post('/publishProduct', [ProductOwnerController::class, 'store']);
Route::delete('/destroyProduct/{id}', [ProductOwnerController::class, 'destroyProduct']);
Route::put('/editProduct/{id}', [ProductOwnerController::class, 'edit']);

/*-----------------------CLIENT-----------------------*/
Route::post('/postFeedback', [ClientController::class, 'postfeedback']);
Route::put('/editFeedback/{id}', [ClientController::class, 'editfeedback']);
Route::delete('/destroyFeedback/{id}', [ClientController::class, 'destroyfeedback']);
Route::get('/showmyfeedbacks', [ClientController::class, 'showmyfeedbacks']);
Route::post('/orderProduct', [ClientController::class, 'orderProduct']);
Route::put('/editOrderProduct/{id}', [ClientController::class, 'editOrderProduct']);
Route::get('/showfeedbacks', [ClientController::class, 'showfeedbacks']);
Route::get('/showMyProduct/{id}', [ClientController::class, 'showMyProduct']);
Route::get('/myallorders', [ClientController::class, 'myallorders']);


Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    // return $request->user();
    // Route::get('/products', [ProductOwnerController::class, 'products']);
});


