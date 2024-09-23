<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ecommerce\Costumer\RegisterCostumerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EcommerceAuthController extends Controller
{
    public function loginEcommerce()
    {
        return view('partials.ecommerce.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('ecommerce')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function registerForm()
    {
        return view('partials.ecommerce.auth.register');
    }

    public function registerStore(RegisterCostumerRequest $request)
    {
        $data = $request->all();

        Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:costumers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required'],
        ]);
    }
}
