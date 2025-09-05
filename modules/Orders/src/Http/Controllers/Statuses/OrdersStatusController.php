<?php

namespace Modules\Orders\Http\Controllers\Statuses;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Illuminate\Validation\Rule;
use Modules\Admin\Models\Status;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Orders\DataView\OrdersStatuses;
use Modules\Admin\Models\LeadStatusesModels;
use Modules\Admin\DataView\Settings\Statuses\LeadStatuses;

class OrdersStatusController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(OrdersStatuses::class)->process();
        return view('orders::order-statuses.index', compact('lists'));
    }

    public function create()
    {
        return view('orders::order-statuses.form');
    }

    public function edit(Request $request)
    {
        return view('orders::order-statuses.form');
    }
}
