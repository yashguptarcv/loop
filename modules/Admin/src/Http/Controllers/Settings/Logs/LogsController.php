<?php

namespace Modules\Admin\Http\Controllers\Settings\Logs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Acl\Services\RoleService;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\DataView\Settings\RolesGrid;
use Modules\Admin\DataView\Settings\Logs\LogsGrid;

class LogsController extends Controller
{
    public function index()
    {
        $lists = fn_datagrid(LogsGrid::class)->process();
        return view('admin::settings.roles.index', compact('lists'));
     
    }

}