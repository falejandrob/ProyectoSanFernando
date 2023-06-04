<?php

namespace App\Http\Controllers;



use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ApiLoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->credentials($request);
        if (Auth::attempt($credentials)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            $user = Auth::user();
            $token = $user->createToken($request->email)->plainTextToken;

            return response()->json([
                'token' => $token,
                'home_url' => url("/home"),
            ]);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function loginToken(Request $request)
    {
        $plainTextToken = $request->input('token');

        // Find the token in the database
        $personalAccessToken = PersonalAccessToken::where('token', hash('sha256', $plainTextToken))->first();

        if (! $personalAccessToken) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        // Get the user related to the token
        $user = $personalAccessToken->tokenable;

        // Login the user into the application.
        Auth::login($user);

        return response()->json([
            'message' => 'Logged in successfully.',
            'home_url' => url("/home"),
        ]);
    }


}
