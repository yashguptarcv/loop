<?php

namespace Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Notifications\DataView\LogsGrid;

class LogsController extends Controller
{
    public function index()
    {
        $lists = fn_datagrid(LogsGrid::class)->process();
        return view('notifications::logs.index', compact('lists'));
     
    }

}