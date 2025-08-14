<?php

namespace Modules\Meetings\DataView;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\DataView\DataGrid;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\DataView\ColumnTypes\Integer;

class MeetingsList extends DataGrid
{
    protected $primaryColumn = "id";

    protected $itemsPerPage = 10;

    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $meetings = DB::table('meetings');
        if (fn_get_setting('general.settings.lead_assigned_user') != auth('admin')->id()) {
            $meetings->where('admin_id', auth('admin')->id());
        }
        // where('start_time', '>=', Carbon::now())
        return $meetings // only upcoming meetings
            ->orderBy('start_time', 'asc')
            ->select(
                '*'
            );
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => 'ID',
            'type' => 'integer',
            'searchable' => false,
            'filterable' => false,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => 'Title',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'description',
            'label' => 'Event Detail',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'start_time',
            'label' => 'Meeting Start / Duration / Status',
            'type' => 'date',
            'searchable' => false,
            'filterable' => false,
            'filterable_type' => 'date_range',
            'sortable' => false,
            'closure' => function ($row) {

                $start = Carbon::parse($row->start_time);
                $end   = Carbon::parse($row->end_time);

                // Formatted output
                $formattedStart = $start->format('M d, Y | g:i A'); // Aug 11, 2025 | 3:49 PM
                $formattedEnd   = $end->format('M d, Y | g:i A');   // Aug 11, 2025 | 4:19 PM

                // Duration
                $diff = $start->diff($end);
                $durationReadable = ($diff->h ? $diff->h . ' hr ' : '') . ($diff->i ? $diff->i . ' mins' : '');
                // Check if meeting is past
                $isPast = $end->isPast(); // true if meeting already ended

                return $formattedStart . " / <span class='bg-blue-100 text-blue-600 px-2 py-1 rounded'>" . $durationReadable . "</span> /  " . ($isPast ? "<span class='bg-red-100 text-red-600 px-2 py-1 rounded'>Closed</span>" : "<span class='bg-blue-100 text-blue-600 px-2 py-1 rounded'>Upcomming</span>");
            },
        ]);

        $this->addColumn([
            'index' => 'location',
            'label' => 'Venue',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'google_event_id',
            'label' => 'Google Event ID',
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Created At',
            'type' => 'date',
            'searchable' => false,
            'filterable' => false,
            'filterable_type' => 'date_range',
            'sortable' => false,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {

        if (bouncer()->hasPermission('admin.meetings.edit')) {
            $this->addAction([
                'title'     => 'Edit',
                'icon'      => 'edit',
                'method'    => 'GET',
                'modal'     => true,
                'url'       => function ($row) {
                    return route('admin.meetings.edit', $row->id);
                },
            ]);
        }

        if (bouncer()->hasPermission('admin.meetings.destroy')) {
            $this->addAction([
                'icon' => 'delete',
                'title' => 'Delete',
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.meetings.destroy', $row->id);
                },
            ]);
        }
    }
}
