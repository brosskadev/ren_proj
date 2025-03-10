<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
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
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
