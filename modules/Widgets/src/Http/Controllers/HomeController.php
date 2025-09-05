<?php

namespace Modules\Widgets\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Widgets\Models\Widget;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Modules\Widgets\Services\WidgetQueryBuilder;
use Modules\Widgets\Http\Requests\StoreWidgetRequest;

class HomeController extends Controller
{
    public function index()
    {
        $widgets = Widget::orderBy('sort_order', 'asc')->get();
        return view('widgets::widgets', compact('widgets'));
    }

    public function create()
    {
        $tables = WidgetQueryBuilder::listTables();
        return view('widgets::form', compact('tables'));
    }

    public function show(Widget $widget)
    {
        $groups = fn_get_usergroups();
        return view('widgets::components.assigne-modal', compact('widget', 'groups'));
    }

     public function store(StoreWidgetRequest $request)
    {
        $data = $request->validated();
        // Decode joins & conditions safely
        $data['joins'] = $request->filled('joins') ? json_decode($request->joins, true) : [];
        $data['conditions'] = $request->filled('conditions') ? json_decode($request->conditions, true) : [];

        Widget::create($data);

        return redirect()->route('admin.widgets.index')->with('success', 'Widget created successfully.');
    }

    public function update(StoreWidgetRequest $request, Widget $widget)
    {
        $data = $request->validated();
        $data['joins'] = $request->filled('joins') ? json_decode($request->joins, true) : [];
        $data['conditions'] = $request->filled('conditions') ? json_decode($request->conditions, true) : [];

        $widget->update($data);

        return redirect()->route('admin.widgets.index')->with('success', 'Widget updated successfully.');
    }

     public function destroy(Request $request, $id)
    {
        try {
            Widget::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Widget deleted',
                'redirect_url' => route('admin.widgets.index'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Something went wrong. Please try again.'.$e->getMessage()
            ]);
        }
    }

    public function sort(Request $request)
    {
        foreach ($request->order as $item) {
            Widget::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['status' => 'success']);
    }

    public function updatePosition(Request $request)
    {
        foreach ($request->positions as $pos) {
            Widget::where('id', $pos['id'])->update([
                'pos_x' => $pos['x'],
                'pos_y' => $pos['y'],
                'width' => $pos['w'],
                'height' => $pos['h'],
            ]);
        }
        return response()->json(['status' => 'success']);
    }

    public function assign(Request $request, Widget $widget)
    {
        try {
            $val = $request->validate(['user_groups' => 'required|array']);
            $widget->update(['user_groups' => $val['user_groups']]);

            return response()->json([
                'success' => true,
                'message' => 'Widget assigned',
                'redirect_url' => route('admin.widgets.index'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * Returns an array/object “$payload” ready for Blade partials.
     */
    public function render(Widget $widget)
    {
        $authId = $authId ?? 0;

        $payload = $this->compute($widget);
        return view("admin.widgets.types.{$widget->widget_type}", $payload);
    }

    /**
     * Core engine: builds the query and computes the widget's data.
     */
    public function compute(Widget $widget, $authId = null, $type = 'admin_id'): array
    {

        // Base query with joins + conditions + date filters
        
        $q = WidgetQueryBuilder::base($widget->table_name);
        $q = WidgetQueryBuilder::applyJoins($q, $widget->joins);
        $q = WidgetQueryBuilder::applyConditions($q, $widget->conditions);
        $q = WidgetQueryBuilder::applyDateFilter(
            $q,
            $widget->date_column,
            $widget->date_filter,
            $widget->date_from,
            $widget->date_to
        );

        if (!empty($userId) && Schema::hasColumn($widget->table_name, $type)) {
            $q->where($type, $userId);
        }

        $data = null;

        if ($widget->operation === 'month_compare') {
            $now = now();

            // Decide period ranges based on date_filter
            switch ($widget->date_filter) {
                case 'today':
                    $currentStart = $now->copy()->startOfDay();
                    $currentEnd   = $now->copy()->endOfDay();
                    $lastStart    = $now->copy()->subDay()->startOfDay();
                    $lastEnd      = $now->copy()->subDay()->endOfDay();
                    break;

                case 'week':
                    $currentStart = $now->copy()->startOfWeek();
                    $currentEnd   = $now->copy()->endOfWeek();
                    $lastStart    = $now->copy()->subWeek()->startOfWeek();
                    $lastEnd      = $now->copy()->subWeek()->endOfWeek();
                    break;

                case 'month':
                default:
                    $currentStart = $now->copy()->startOfMonth();
                    $currentEnd   = $now->copy()->endOfMonth();
                    $lastStart    = $now->copy()->subMonth()->startOfMonth();
                    $lastEnd      = $now->copy()->subMonth()->endOfMonth();
                    break;
            }

            // Build current + last queries with all joins/conditions
            $current = WidgetQueryBuilder::applyConditions(
                WidgetQueryBuilder::applyJoins(WidgetQueryBuilder::base($widget->table_name), $widget->joins),
                $widget->conditions
            )->whereBetween($widget->date_column, [$currentStart, $currentEnd]);

            $last = WidgetQueryBuilder::applyConditions(
                WidgetQueryBuilder::applyJoins(WidgetQueryBuilder::base($widget->table_name), $widget->joins),
                $widget->conditions
            )->whereBetween($widget->date_column, [$lastStart, $lastEnd]);

            // Aggregate
            if ($widget->column_name) {
                $currentVal = $current->sum(DB::raw($widget->column_name));
                $lastVal    = $last->sum(DB::raw($widget->column_name));
            } else {
                $currentVal = $current->count();
                $lastVal    = $last->count();
            }

            $diff = $currentVal - $lastVal;
            $percent = $lastVal > 0 ? round(($diff / $lastVal) * 100, 2) : 100;

            $data = [
                'current' => $currentVal,
                'last'    => $lastVal,
                'diff'    => $diff,
                'percent' => $percent,
                'range'   => [
                    'current' => [$currentStart->toDateTimeString(), $currentEnd->toDateTimeString()],
                    'last'    => [$lastStart->toDateTimeString(), $lastEnd->toDateTimeString()],
                ],
                'widget'  => $widget,
            ];
        } elseif ($widget->operation === 'profit_loss') {
            $revenue = $q->sum($widget->revenue_column);
            $cost    = $q->sum($widget->cost_column);

            $data = [
                'value'  => $revenue - $cost,
                'widget' => $widget,
            ];
        } else {
            if (in_array($widget->widget_type, ['line', 'bar', 'pie'])) {
                if ($widget->group_by) {
                    $rows = $q->selectRaw($widget->group_by . ' AS grp, ' .
                        ($widget->operation === 'count'
                            ? 'COUNT(*) AS val'
                            : strtoupper($widget->operation) . '(' . $widget->column_name . ') AS val'))
                        ->groupBy('grp')
                        ->orderBy('grp')
                        ->get();
                } elseif ($widget->date_column) {
                    $dateExpr = 'DATE(' . $widget->date_column . ')';
                    $rows = $q->selectRaw($dateExpr . ' AS grp, ' .
                        ($widget->operation === 'count'
                            ? 'COUNT(*) AS val'
                            : strtoupper($widget->operation) . '(' . $widget->column_name . ') AS val'))
                        ->groupBy('grp')
                        ->orderBy('grp')
                        ->get();
                } else {
                    $rows = collect([(object)[
                        'grp' => 'Total',
                        'val' => $this->aggregate($q, $widget->operation, $widget->column_name),
                    ]]);
                }
                $data = ['rows' => $rows, 'widget' => $widget];
            } elseif ($widget->widget_type === 'worldmap') {
                // Handle JSON or normal column for grouping
                if (str_contains($widget->group_by ?: $widget->column_name, '->')) {
                    [$col, $jsonKey] = explode('->', $widget->group_by ?: $widget->column_name, 2);
                    $countryCol = "JSON_UNQUOTE(JSON_EXTRACT($col, '$.$jsonKey'))";
                } else {
                    $countryCol = $widget->group_by ?: $widget->column_name;
                }

                // Build aggregation expression dynamically
                $aggregateExpr = match (strtolower($widget->operation ?? 'count')) {
                    'count' => 'COUNT(*)',
                    'sum'   => 'SUM(' . ($widget->column_name ?? '0') . ')',
                    'avg'   => 'AVG(' . ($widget->column_name ?? '0') . ')',
                    'min'   => 'MIN(' . ($widget->column_name ?? '0') . ')',
                    'max'   => 'MAX(' . ($widget->column_name ?? '0') . ')',
                    default => 'COUNT(*)',
                };

                $rows = $q
                    ->selectRaw("$countryCol AS country, $aggregateExpr AS val")
                    ->groupBy('country')
                    ->get()->toArray();


                $data = [
                    'rows'   => $rows,
                    'widget' => $widget,
                ];
            } else {
                
                $val = $this->aggregate($q, $widget->operation, $widget->column_name);
                $data = ['value' => $val, 'widget' => $widget];
            }
        }

        return $data;
    }


    protected function aggregate($q, string $op, ?string $col)
    {
        return match ($op) {
            'count' => $q->count(),
            'sum'   => $q->sum(DB::raw($col ?? '0')),
            'avg'   => $q->avg(DB::raw($col ?? '0')),
            'min'   => $q->min(DB::raw($col ?? '0')),
            'max'   => $q->max(DB::raw($col ?? '0')),
            default => null,
        };
    }
}
