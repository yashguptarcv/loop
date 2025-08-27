<?php

namespace Modules\Admin\Http\Controllers\Settings\Statuses;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Acl\Services\UserAdminService;
use Modules\Admin\DataView\Settings\OrdersStatuses;
use Modules\Admin\DataView\Settings\Statuses\LeadStatuses;
use Modules\Admin\Models\LeadStatusesModels;
use Modules\Admin\Models\Status;

class OrdersStatusController extends Controller
{
    public function index(Request $request)
    {
        $lists = fn_datagrid(OrdersStatuses::class)->process();
        return view('admin::settings.order-statuses.index', compact('lists'));
    }

    public function create()
    {
        return view('admin::settings.statuses.order.form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'color' => 'required|string',
            'sort' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $user = LeadStatusesModels::create([
                'name'  => $request['name'],
                'color'  => $request['color'],
                'sort'  => $request['sort']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead statuses created successfully!',
                'redirect_url' => route('admin.settings.statuses.leads.index')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $lead = Status::where('id', $id)->first(); // You should already have a method like this in your service
        if (!$lead) {
            return redirect()->route('admin.settings.statuses.leads.index')->with('error', 'Lead statuses not found.');
        }
        return view('admin::settings.statuses.leads.form', compact('lead'));
    }
}
