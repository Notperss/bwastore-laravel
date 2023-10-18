<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardTransactionController extends Controller
{
    public function index(){
        return view('pages.dahsboard-transactions');
    }
    public function details(){
        return view('pages.dahsboard-transactions-details');
    }
}
