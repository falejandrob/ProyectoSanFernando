<?php

use App\Http\Controllers\ApiLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





/*Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        $cookiejar = Auth::getCookieJar();

        $economandoSession = $request->cookie('economando_session');

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'token' => $cookiejar,
            'home_url' => url("/home"),
            'economando_session' => $economandoSession,
        ]);
    } else {
        return response()->json([
            'message' => 'The provided credentials do not match our records.',
        ], 403);
    }
});*/

Route::post('/login',[ApiLoginController::class, 'login']);
Route::post('/loginToken',[ApiLoginController::class, 'loginToken']);
Route::post('/register', [ApiLoginController::class, 'register']);



