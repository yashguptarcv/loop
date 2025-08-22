<?php

namespace Modules\Customers\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customers\DataView\Customers;
use Modules\Customers\Models\User as ModelsUser;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(Customers::class)->process();
        return view("customers::customers.index", compact('lists'));
    }
    
    public function show(ModelsUser $customer) {        
        
        return view("customers::customers.show", compact('customer'));
    }
} 