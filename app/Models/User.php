<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo', 
        'password', // Agregar password
        'telefono',
        'rol',
    ];

    protected $casts = [
        'rol' => UserRole::class,
    ];

    // Método para hashear la contraseña automáticamente
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Opcional: Método para verificar contraseña
    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}