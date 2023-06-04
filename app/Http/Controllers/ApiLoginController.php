<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use function MongoDB\BSON\toJSON;

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

    public function register(Request $request)
    {

        $data = $request->all();

        // Use a custom validation error message
        $messages = array(
            'nombre.required' => 'El campo nombre es obligatorio.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El formato del correo electrónico es inválido.',
            'email.max' => 'El email no debe exceder los 255 caracteres.',
            'email.unique' => 'El email ingresado ya está en uso.',
            'email.regex' => 'El email debe tener el dominio @educarex.es.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        );

        // Validate the incoming request
        $validator = Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9._%+-]+@educarex\.es$/i'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);

        // If the validation fails, return the validation error response
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create a new user
        $user = User::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
        ]);

        // Assign role to user
        $user->assignRole('profesor');

        // Login the user into the application.
        Auth::login($user);

        // Create a new token for the user
        $token = $user->createToken($request->email)->plainTextToken;

        // Return response
        // Return response
        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
            'home_url' => url("/home"),
        ], 201);
    }



}
