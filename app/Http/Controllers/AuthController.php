<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión del usuario.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {

            /*
             * Obtenemos nuevamente el usuario mediante el modelo User.
             * Esto permite trabajar directamente con Eloquent.
             */
            $user = User::findOrFail(Auth::id());

            /*
             * Guardamos en la sesión la fecha de la conexión anterior
             * antes de actualizarla con la conexión actual.
             */
            if ($user->last_login_at) {
                $request->session()->put(
                    'last_login_at',
                    $user->last_login_at
                        ->format('d/m/Y h:i:s A')
                );

            } else {
                $request->session()->put(
                    'last_login_at',
                    null
                );
            }
            
            $user->last_login_at = now();
            $user->save();

            /*
             * Actualizamos la fecha y hora de la conexión actual.
             */
            $user->last_login_at = now('America/Santo_Domingo');
            $user->save();

            /*
             * Regeneramos la sesión por seguridad.
             */
            $request->session()->regenerate();

            return redirect()->intended('/')->with(
                'success',
                'Inicio de sesión exitoso.'
            );
        }

        return back()
            ->withErrors([
                'email' => 'El correo electrónico o la contraseña son incorrectos.',
            ])
            ->onlyInput('email');
    }

    /**
     * Muestra el formulario de registro.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in(['Cliente', 'Proveedor']),
            ],

            'business_name' => [
                'required_if:role,Proveedor',
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'required_if:role,Proveedor',
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'required_if:role,Proveedor',
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $role = Role::where('name', $validated['role'])->firstOrFail();

        $user = DB::transaction(function () use ($validated, $role) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id,
            ]);

            if ($role->name === 'Proveedor') {

                Supplier::create([
                    'user_id' => $user->id,
                    'business_name' => $validated['business_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'status' => 'pending',
                ]);
            }

            return $user;
        });

        if ($role->name === 'Proveedor') {

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Registro realizado correctamente. Su solicitud como proveedor está pendiente de aprobación.'
                );
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/')->with(
            'success',
            'Registro realizado correctamente.'
        );
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with(
            'success',
            'Sesión cerrada correctamente.'
        );
    }
}

