<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{ 
    function index(){
         $user = Auth::user();
        return view('user/index', compact('user'));
    }
    function trainer(){
        $trainer= Auth::user();
        return view('trainer/index', compact('trainer'));
       
    }
    function admin(){
        return view('admin/index');
    }
    
}

