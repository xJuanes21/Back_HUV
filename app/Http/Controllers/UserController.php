<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,correo',
            'password' => 'required|string|min:6', // Agregar validación de password
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|in:' . implode(',', UserRole::values()),
        ]);

        $user = User::create($validated);

        // No retornar el password en la respuesta
        return response()->json([
            'id' => $user->id,
            'nombre' => $user->nombre,
            'correo' => $user->correo,
            'telefono' => $user->telefono,
            'rol' => $user->rol,
            'created_at' => $user->created_at,
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'id' => $user->id,
            'nombre' => $user->nombre,
            'correo' => $user->correo,
            'telefono' => $user->telefono,
            'rol' => $user->rol,
            'created_at' => $user->created_at,
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:users,correo,' . $user->id,
            'password' => 'sometimes|string|min:6', // Password opcional en update
            'telefono' => 'nullable|string|max:20',
            'rol' => 'sometimes|in:' . implode(',', UserRole::values()),
        ]);

        $user->update($validated);

        return response()->json([
            'id' => $user->id,
            'nombre' => $user->nombre,
            'correo' => $user->correo,
            'telefono' => $user->telefono,
            'rol' => $user->rol,
            'updated_at' => $user->updated_at,
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }
}