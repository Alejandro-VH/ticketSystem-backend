<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['Login', 'Register']]);
    }

    // Funciones
    public function Login(Request $request)
    {
        $messages = $this->GetMessages();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);

        $credentials = $request->only(['email', 'password']);

        try {
            if (! $token = JWTAuth::attempt($credentials)){
                return response([
                    'message' => 'Credenciales incorrectas',
                    'data' => [],
                    'error' => true,
                ], 401);
            }

            $user = JWTAuth::user();

            return response([
                'message' => 'Se ha iniciado sesión exitosamente',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
                'error' => false,
            ],200);
            
        }catch (Exception $e){
            return response([
                'message' => 'Hubo un error al iniciar sesión, intentelo más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ],500);
        }

    }

    public function Register(Request $request)
    {
        $messages = $this->GetMessages();
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        // Rol: usuario
        $user->role_id = '3'; 
        $user->save();

        return response([
            'message' => 'Usuario creado exitosamente',
            'data' => [$user],
            'error' => false,
        ],200);
    }

    public function Logout()
    {
        Auth::logout();

        return response([
            'message' => 'Sesión cerrada exitosamente',
            'data' => [],
            'error' => false,
        ],200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $currentToken = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($currentToken);
        return $this->respondWithToken($newToken);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    // Gets 
    public function GetUserById($id){
        try{
            $user = User::find($id);
            if (!$user) {
                return response([
                    'message' => 'No se encontró el usuario indicado',
                    'data' => [],
                    'error' => true,
                ], 404);
            }
            return response([
                'message' => 'Usuario encontrado exitosamente',
                'data' => [$user],
                'error' => false,
            ],200);
        } catch(Exception $e){
            return response([
                'message' => 'Hubo un error al obtener el usuario, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ],500);
        }
    }

    public function GetAllUsers(){
        try{
            $users = User::all();

            if (!$users) {
                return response([
                    'message' => 'No se encontraron usuarios',
                    'data' => [],
                    'error' => true,
                ], 404);
            }

            return response([
                'message' => 'Usuarios encontrados exitosamente',
                'data' => [$users],
                'error' => false,
            ],200);

        } catch(Exception $e){
            return response([
                'message' => 'Hubo un error al obtener el usuario, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ],500);
        }
    }

    public function GetLoggedUser(){
        return response([
            'message' => 'Usuario logeado:',
            'data' => [
                'user' => Auth::user()
            ],
            'error' => false
        ], 200);
    }

    private function GetMessages(){
        $messages = [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no puede tener más de 255 caracteres',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico no es válido',
            'email.unique' => 'El correo electrónico ya está en uso',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de texto',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
        return $messages;
    }
}
