<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function showDashboard(Request $request){
        $users = User::all();

        return view("dashboard", compact('users'));
    }
}
