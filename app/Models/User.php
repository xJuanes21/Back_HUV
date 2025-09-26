<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens; 

class User extends Model
{
    use HasFactory, HasApiTokens; 

    protected $fillable = [
        'nombre',
        'correo', 
        'password',
        'telefono',
        'rol',
    ];

    protected $casts = [
        'rol' => UserRole::class,
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}