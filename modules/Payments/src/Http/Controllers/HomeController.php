<?php

namespace Modules\Payments\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Payments\DataView\PaymentsMethodView;
use Modules\Payments\Models\PaymentMethod;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(PaymentsMethodView::class)->process();
        return view('payments::index', compact('lists'));
    }

    public function create() {
        $processors = PaymentMethod::get();
        return view('payments::form', compact('processors'));
    }
} 