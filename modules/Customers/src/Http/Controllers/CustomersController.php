<?php

namespace Modules\Customers\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        return view("customers::customers.index");
    }
} 