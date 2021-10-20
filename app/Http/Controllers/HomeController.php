<?php

namespace App\Http\Controllers;
use App\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        return view('auth.login');
    }

}
