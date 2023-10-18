<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardProductController extends Controller
{
    public function index(){
        return view('pages.dahsboard-products');
    }

     public function details(){
        return view('pages.dahsboard-products-details');
    }
     public function create(){
        return view('pages.dahsboard-products-create');
    }
}
