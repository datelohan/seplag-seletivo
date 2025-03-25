<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'showLoginForm', 'showRegisterForm']]);
    }

    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the registration form
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($request->wantsJson()) {
                // API Login
                if (!$token = Auth::guard('api')->attempt($credentials)) {
                    return response()->json([
                        'error' => 'Credenciais inválidas'
                    ], 401);
                }
                return $this->respondWithToken($token);
            } else {
                // Web Login
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect('/dashboard');
                }
                
                return back()->withErrors([
                    'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
                ])->withInput($request->only('email'));
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Erro ao processar login: ' . $e->getMessage()
                ], 500);
            }
            return back()->withError('Erro ao processar login: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ], [
                'name.required' => 'O campo nome é obrigatório',
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'Por favor, insira um email válido',
                'email.unique' => 'Este email já está em uso',
                'password.required' => 'O campo senha é obrigatório',
                'password.min' => 'A senha deve ter pelo menos 6 caracteres',
                'password.confirmed' => 'As senhas não conferem',
                'password_confirmation.required' => 'A confirmação de senha é obrigatória'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            if ($request->wantsJson()) {
                // API Register
                $token = Auth::guard('api')->login($user);
                return $this->respondWithToken($token);
            } else {
                // Web Register
                Auth::login($user);
                return redirect('/dashboard')->with('success', 'Registro realizado com sucesso!');
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Erro ao registrar usuário: ' . $e->getMessage()
                ], 500);
            }
            return back()
                ->withErrors($e->validator ?? ['error' => $e->getMessage()])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            return response()->json(Auth::guard('api')->user());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao obter dados do usuário: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->wantsJson()) {
            // API Logout
            Auth::guard('api')->logout();
            return response()->json(['message' => 'Logout realizado com sucesso']);
        } else {
            // Web Logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(Auth::guard('api')->refresh());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao renovar token: ' . $e->getMessage()
            ], 500);
        }
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
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}