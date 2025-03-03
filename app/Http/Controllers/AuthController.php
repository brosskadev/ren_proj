<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showloginpage(){
        return view('login_page');
    }

    public function login(LoginRequest $request){

        if ($this->authService->login($request->email, $request->password)){
            $request->session()->regenerate();
            return redirect('/main');
        }

        return back()->withErrors(['email' => 'Неверные учетные данные']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
