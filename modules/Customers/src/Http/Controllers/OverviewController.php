<?php

namespace Modules\Customers\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Acl\Models\Admin;
use Modules\Orders\Models\Order;
use Illuminate\Routing\Controller;
use Modules\Leads\Models\Application;
use Modules\Customers\DataView\ApplicationGrid;
use Modules\Customers\DataView\CustomerOrderGrid;
use Modules\Customers\Models\User as  ModelsUser;
use Modules\Customers\DataView\CustomerTransactionGrid;

class OverviewController extends Controller
{
    public function orders(ModelsUser $customer)
    {
        $lists = fn_datagrid(CustomerOrderGrid::class)->process();
        return view("customers::customers.show", compact('customer', 'lists'))->with('activeTab', 'orders');
    }

    public function bulkDelete(ModelsUser $customer, Request $request)
    {
        $request->validate([
            'rows' => 'required|array',
            'rows.*' => 'exists:orders,id,user_id,' . $customer->id
        ]);

        try {
            $deleted = Order::whereIn('id', $request->rows)
                ->where('user_id', $customer->id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted $deleted order(s)."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting orders: ' . $e->getMessage()
            ]);
        }
    }


    public function application(ModelsUser $customer)
    {
        // $lists = LeadDataGrid::where('user_id', $customer->id)->first();
        $lists = fn_datagrid(ApplicationGrid::class)->process();
        return view("customers::customers.show", compact('customer', 'lists'))->with('activeTab', 'application');
    }

    public function applicationDetailsDelete(ModelsUser $customer, $leadId)
    {
        try {
            $application = Application::where('id', $leadId)
                ->where('email', $customer->email)
                ->firstOrFail();

            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Application deleted successfully.',
                'redirect' => route('admin.customers.show', $customer->id)
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found or you do not have permission to delete it.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting application: ' . $e->getMessage()
            ]);
        }
    }

    public function transactions(ModelsUser $customer)
    {
        $lists = fn_datagrid(CustomerTransactionGrid::class)->process();
        return view("customers::customers.show", compact('customer', 'lists'))->with('activeTab', 'transactions');
    }
} 