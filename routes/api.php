<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login',[ApiController::class,'login']);
Route::get('spendtime',[ApiController::class,'Spendtime']);
Route::get('education',[ApiController::class,'Education']);
Route::Post('signup',[ApiController::class,'SignUp']);
Route::Post('gallery',[ApiController::class,'UserGallery']);
Route::get('profileget/{id}',[ApiController::class,'ProfileGet']);

Route::get('homescreen/{id}',[ApiController::class,'HomeScreen']);
Route::get('usercoin/{id}',[ApiController::class,'UserCoin']);
Route::get('razorpayorder/{id}',[ApiController::class,'RazorpayOrder']);

Route::Post('Islike',[ApiController::class,'Islike']);
Route::Post('superlike',[ApiController::class,'SuperLike']);


Route::Post('UnlockProfile',[ApiController::class,'UnlockProfile']);

Route::Post('userchat',[ApiController::class,'UserChat']);
Route::Get('userchat/{userid}/{myid}',[ApiController::class,'MyUserChart']);

Route::get("chatlist/{any}",[ApiController::class,'ChatList']);
