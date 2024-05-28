<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function canales(){
        $canales = Canal::where('tipo', 'público')->get();
        if(Auth::check()){
            $user_id = Auth::user()->id;
        }
        return view('panel.home', compact('canales'));
    }
}
