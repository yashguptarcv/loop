<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customers\DataView\Customers;
use Modules\Customers\Models\User as Customer;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(Customers::class)->process();
        return view("customers::customers.index", compact('lists'));
    }
    
    public function show(Customer $customer) 
    {        
        return view("customers::customers.show", compact('customer'));
    }

    public function create()
    {
      
    }

    public function store(Request $request)
    {
        
    }

    public function edit(Customer $customer)
    {
        
    }

    public function update(Request $request, Customer $customer)
    {
       
    }

    public function destroy(Customer $customer)
    {
   
    }

    public function bulkDelete(Request $request)
    {
        
    }
}
