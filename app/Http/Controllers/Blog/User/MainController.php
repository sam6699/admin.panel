<?php

namespace App\Http\Controllers\Blog\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');


    }

    public function index(){

        return view('blog.user.index');


    }

}
