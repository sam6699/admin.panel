<?php

namespace App\Http\Controllers\Blog\Admin;

use Meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends AdminBaseController
{
    public function index(){

        Meta::title('админ панель');
        return view('blog.admin.main.index');

    }
}
