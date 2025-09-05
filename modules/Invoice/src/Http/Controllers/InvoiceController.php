<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        return view('invoice::index');
    }
} 