<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Maneja el registro de un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // --- Paso 1: Validación de Datos ---
        // Validamos que los datos de entrada sean correctos.
        // Si la validación falla, Laravel automáticamente devuelve una respuesta de error 422 con los detalles.
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255', // <-- AÑADIDO
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:users', // 'unique:users' asegura que el email no esté ya registrado.
            'email' => 'required|string|email|max:255', // 'unique:users' asegura que el email no esté ya registrado.
            'password' => 'required|string|min:8|confirmed', // 'confirmed' busca un campo 'password_confirmation' que debe coincidir.
        ]);

        // --- Paso 2: Encriptación de Contraseña y Creación de Usuario ---
        // Usamos el facade `Hash` para encriptar la contraseña de forma segura.
        // NUNCA guardes contraseñas en texto plano. Hash::make() es un algoritmo de un solo sentido.
        try {
            $user = User::create([
                'first_name' => $validatedData['first_name'], // <-- AÑADIDO
                'last_name'  => $validatedData['last_name'],
                'user_name'  => $validatedData['user_name'],
                'email'      => $validatedData['email'],
                'password'   => Hash::make($validatedData['password']),
            ]);
        } catch (\Exception $e) {
            // En caso de un error inesperado al crear el usuario
            return response()->json([
                'message' => 'Could not create user.',
                'error' => $e->getMessage()
            ], 500); // 500: Internal Server Error
        }

        // --- Paso 3: Respuesta Exitosa (JSON) ---
        // Devolvemos una respuesta clara de que el usuario fue creado.
        // El código de estado 201 significa "Created".
        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user
        ], 201);
    }
     public function login(Request $request)
    {
        // --- Paso 1: Validación de Datos ---
        // Validamos que el email y la contraseña hayan sido enviados.
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        // --- Paso 2: Intentar la Autenticación ---
        // Buscamos al usuario por su email.
        $user = User::where('user_name', $request->user_name)->first();

        // Verificamos si el usuario existe Y si la contraseña es correcta.
        // `Hash::check` compara la contraseña en texto plano enviada por el usuario
        // con el hash seguro que tenemos en la base de datos.
        if (! $user || ! Hash::check($request->password, $user->password)) {
            // Si las credenciales son incorrectas, lanzamos una excepción de validación.
            // Esto devuelve una respuesta 422 con un mensaje de error claro.
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // --- Paso 3: Generar el Token de API ---
        // Si las credenciales son correctas, creamos un token para el usuario.
        // Este token será usado para autenticar las futuras peticiones a la API.
        $token = $user->createToken('auth_token')->plainTextToken;

        // --- Paso 4: Respuesta Exitosa (JSON) ---
        // Devolvemos una respuesta con el token de acceso y los datos del usuario.
        return response()->json([
            'message'      => '¡Login exitoso!',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user,
        ]);
    }
}