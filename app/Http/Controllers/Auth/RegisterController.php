<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Notifications\WelcomeUser;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'employee', // Rol por defecto
            'email_verified_at' => now(), // Marcar como verificado automáticamente
        ]);

        // Enviar email de bienvenida
        $user->notify(new WelcomeUser());

        Auth::login($user);

        return redirect()->route('dashboard')
                       ->with('success', '¡Cuenta creada exitosamente! Bienvenido, ' . $user->name . '!');
    }
}
