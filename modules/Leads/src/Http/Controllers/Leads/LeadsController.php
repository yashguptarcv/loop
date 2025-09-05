<?php

namespace Modules\Leads\Http\Controllers\Leads;

use Illuminate\Http\Request;
use Modules\Acl\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Modules\Leads\Models\LeadModel;
use Modules\Meetings\Models\Meeting;
use Illuminate\Support\Facades\Storage;
use Modules\Leads\Services\LeadService;
use Illuminate\Support\Facades\Validator;
use Modules\Leads\Models\LeadSourceModel;
use Modules\Leads\Models\LeadStatusModel;
use Modules\Leads\Http\Requests\LeadRequest;
use Modules\Leads\Models\LeadAttachmentModel;
use Modules\Meetings\Services\MeetingService;
use Modules\Leads\Http\Requests\ActivityRequest;
use Modules\Meetings\Services\GoogleCalendarService;

class LeadsController extends Controller
{
    protected $calendarService;
    protected $leadService;
    protected $meetingService;

    public function __construct(
        GoogleCalendarService $calendarService,
        LeadService $leadService,
        MeetingService $meetingService
    ) {
        $this->calendarService = $calendarService;
        $this->leadService = $leadService;
        $this->meetingService = $meetingService;
    }

    public function index(Request $request)
    {
        $lead_statuses = LeadStatusModel::orderBy('sort')->get();

        $query = LeadModel::with(['status', 'tags', 'createdBy']);

        $query->when(
            fn_get_setting('general.lead.user_group') == auth('admin')->user()->role_id,
            function ($q) {
                return $q;
            },
            function ($q) {
                return $q->where('assigned_to', auth('admin')->user()->role_id);
            }
        );

        // 🔹 Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('tags', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('assigned_to')) {
            $query->where('created_by', $request->input('assigned_to'));
        }

        if ($request->filled('source')) {
            $query->where('source_id', $request->input('source'));
        }

        // 🔹 Date sorting
        $sortDirection = $request->filled('sort_date') && in_array(strtolower($request->input('sort_date')), ['asc', 'desc'])
            ? $request->input('sort_date')
            : 'desc';
        $query->orderBy('created_at', $sortDirection);

        if ($request->ajax() && $request->has('status_id')) {
            $leads = $query->where('status_id', $request->status_id)
                ->paginate(fn_get_setting('general.per_page'));

            return response()->json([
                'success'   => true,
                'next_page' => $leads->nextPageUrl(),
                'html'      => view('leads::leads.components.leads_list', [
                    'leads' => $leads
                ])->render()
            ]);
        }

        $leads = $query->paginate(fn_get_setting('general.per_page'));
        return view("leads::leads.index", compact('lead_statuses', 'leads'));
    }

    public function create()
    {
        $leadStatuses = LeadStatusModel::orderBy('sort')->get();
        $leadSources  = LeadSourceModel::where('is_active', '1')->get();
        $users = [];
        return view('leads::leads.lead-form', compact('leadStatuses', 'leadSources', 'users'));
    }

    public function edit(Request $request, $id)
    {
        $lead = LeadModel::find($id);
        $leadStatuses = LeadStatusModel::orderBy('sort')->get();
        $leadSources  = LeadSourceModel::where('is_active', '1')->get();
        $users = [];
        return view('leads::leads.lead-form', compact('lead', 'leadStatuses', 'leadSources', 'users'));
    }

    public function show(Request $request, $id)
    {
        $lead = LeadModel::with(['status', 'source', 'assignedTo', 'tags', 'application'])
            ->findOrFail($id);

        $perPage = fn_get_setting('general.per_page', 10);
        $admins  = Admin::select('id', 'name')->get();

        // Tab-based loading (for AJAX & partial loads)
        if ($request->filled('tab')) {
            $tab = $request->input('tab');

            switch ($tab) {
                case 'activity':
                    $items = $lead->activities()
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage);

                    if ($request->ajax()) {
                        return response()->json([
                            'html'       => view('leads::leads.components.lead-detail-right.activity', [
                                'items' => $items,
                                'lead'  => $lead,
                            ])->render(),
                            'next_page'  => $items->nextPageUrl(),
                            'current'    => $items->currentPage(),
                            'totalPages' => $items->lastPage(),
                        ]);
                    }

                    return view('leads::leads.components.lead-detail-right.activity', compact('items', 'lead'));

                case 'notes':
                    $items = $lead->notes()
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage);

                    if ($request->ajax()) {
                        return response()->json([
                            'html'       => view('leads::leads.components.lead-detail-right.notes', [
                                'items' => $items,
                                'lead'  => $lead,
                            ])->render(),
                            'next_page'  => $items->nextPageUrl(),
                            'current'    => $items->currentPage(),
                            'totalPages' => $items->lastPage(),
                        ]);
                    }

                    return view('leads::leads.components.lead-detail-right.notes', compact('items', 'lead'));

                case 'files':
                    $items = $lead->attachments()
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage);

                    if ($request->ajax()) {
                        return response()->json([
                            'html'       => view('leads::leads.components.lead-detail-right.files', [
                                'items' => $items,
                                'lead'  => $lead,
                            ])->render(),
                            'next_page'  => $items->nextPageUrl(),
                            'current'    => $items->currentPage(),
                            'totalPages' => $items->lastPage(),
                        ]);
                    }

                    return view('leads::leads.components.lead-detail-right.files', compact('items', 'lead'));

                case 'application':
                    $items = $lead->application()
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage);

                    if ($request->ajax()) {
                        return response()->json([
                            'html'       => view('leads::leads.components.lead-detail-right.application', [
                                'items' => $items,
                                'lead'  => $lead,
                            ])->render(),
                            'next_page'  => $items->nextPageUrl(),
                            'current'    => $items->currentPage(),
                            'totalPages' => $items->lastPage(),
                        ]);
                    }

                    return view('leads::leads.components.lead-detail-right.application', compact('items', 'lead'));

                default:
                    return abort(400, 'Invalid tab');
            }
        }

        $viewData = [
            'lead'       => $lead,
            'admins'     => $admins,
            'activities' => $lead->activities()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage),
        ];

        return view('leads::leads.lead-details', $viewData);
    }


    public function store(LeadRequest $request)
    {
        try {
            $validate = $request->validated(); // returns validated data

            $lead = $this->leadService->create($request->all());

            $lead->notes()->create([
                'admin_id'  => auth('admin')->id(),
                'note'      => "Lead created by " . auth('admin')->name,
                'created'   => now()
            ]);

            $this->leadService->handleAttachments($request, $lead);

            return response()->json([
                'success' => true,
                'message' => 'Lead created successfully!',
                'redirect_url' => route('admin.leads.index')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to update lead ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to update: ' . $e->getMessage(),
            ]);
        }
    }

    public function update(LeadRequest $request, LeadModel $lead)
    {
        try {
            $validate = $request->validated(); // returns validated data

            $this->leadService->update($lead, $request->all());

            $this->leadService->handleAttachments($request, $lead);

            return response()->json([
                'success' => true,
                'message' => 'Lead updated successfully!',
                'redirect_url' => route('admin.leads.show', $lead)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to update lead ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to update: ' . $e->getMessage(),
            ]);
        }
    }

    public function downloadAttachment(LeadModel $lead, LeadAttachmentModel $attachment)
    {

        // Verify the attachment belongs to the lead
        if ($attachment->lead_id != $lead->id) {
            session()->flash('error', 'Unable to download attachment');
            return redirect()->route('admin.leads.show', $lead->id);
        }

        $filepath = 'uploads/' . strtolower('leads/') . $lead->id . '/' . $attachment->filename;

        if (!Storage::disk(fn_get_setting('general.image_driver'))->exists($filepath)) {
            session()->flash('error', 'Unable to download attachment');
            return redirect()->route('admin.leads.show', $lead->id);
        }

        $lead->notes()->create([
            'admin_id'  => auth('admin')->id(),
            'note'      => auth('admin')->name . " has been download attachments " . $filepath,
            'created'   => now()
        ]);

        return response()->download('storage/' . $filepath);
    }

    public function destroyAttachment(LeadModel $lead, LeadAttachmentModel $attachment)
    {
        // Verify the attachment belongs to the lead
        if ($attachment->lead_id !== $lead->id) {
            session()->flash('error', 'Attachment not found');
            return redirect()->route('admin.leads.show', $lead->id);
        }

        // Delete main file
        $path = 'uploads/' . strtolower('leads/') . $lead->id . '/';
        Storage::disk(fn_get_setting('general.image_driver'))->delete($path . '/' . $attachment->filename);

        // Add note about the deletion
        $lead->notes()->create([
            'admin_id'  => auth('admin')->id(),
            'note'      => auth('admin')->name . " deleted attachment: " . $attachment->original_filename,
            'created'   => now()
        ]);

        // Delete the attachment record
        $attachment->delete();

        return redirect()->back()->with('success', 'Attachment deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'status_id' => 'required|exists:lead_statuses,id'
        ]);

        $lead = LeadModel::findOrFail($request->lead_id);
        $lead->status_id = $request->status_id;
        $lead->save();

        return response()->json([
            'success' => true,
            'message' => 'Lead status updated successfully'
        ]);
    }

    // lead activity

    public function storeActivity(ActivityRequest $request, LeadModel $lead)
    {
        try {

            $request->validated(); // returns validated data

            // Process mentions in the description
            $description = $this->processMentions($request->description);

            $activity = $lead->activities()->create([
                'admin_id' => auth('admin')->id(),
                'type' => $request['type'],
                'description' => $description,
                'activity_date' => now(),
                'duration_minutes' => $request['duration_minutes'] ?? 0,
                'schedule_meeting' => $request['meeting_date'] ?? '',
                'outcome' => $request['outcome'] ?? 'neutral'
            ]);

            $lead->update([
                'updated_at' => now()
            ]);

            // Handle file uploads
            $this->leadService->handleAttachments($request, $lead);

            if (!empty($request['meeting_date'])) {

                $meeting = $this->meetingService->create([
                    'start_time'    => Carbon::parse($request['meeting_date']),
                    'title'         => auth('admin')->name . " Schedule a meeting with " . $lead->name,
                    'description'   => $description,
                    'location'      => '',
                    'color'         => '##0099cc',
                    'admin_id'      => auth('admin')->id(),
                ]);

                $lead->notes()->create([
                    'admin_id'  => auth('admin')->id(),
                    'note'      => auth('admin')->name . " Schedule a meeting on " . $request['meeting_date'] . "\n, Google meeting ID: $meeting->google_event_id ?? $meeting->id",
                    'created'   => now()
                ]);
                session()->flash('success', 'Meeting created successfully');
            }

            return response()->json([
                'success' => true,
                'message' => 'Activity added successfully',
                'activity' => $activity,
                'redirect_url' => route('admin.leads.show', $lead->id)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => 'Unable to activity ' . $e->getMessage(),
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => 'Unable to activity: ' . $e->getMessage(),
            ]);
        }
    }

    private function processMentions($content)
    {
        // Convert mention spans to database format
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new \DOMXPath($dom);
        $mentions = $xpath->query("//span[contains(@class, 'mention')]");

        foreach ($mentions as $mention) {
            $adminId = $mention->getAttribute('data-mention-id');
            $admin = Admin::find($adminId);

            if ($admin) {
                // Replace with a special format you can parse later
                $replacement = $dom->createTextNode("[@admin:{$adminId}:{$admin->name}]");
                $mention->parentNode->replaceChild($replacement, $mention);
            }
        }

        return $dom->saveHTML();
    }

    public function parseActivityDescription($description)
    {
        // Convert [@admin:1:John Doe] to linked mentions
        return preg_replace_callback(
            '/\[@admin:(\d+):([^\]]+)\]/',
            function ($matches) {
                $adminId = $matches[1];
                $adminName = $matches[2];
                $admin = Admin::find($adminId);

                if ($admin) {
                    return '<a href="' . route('admin.users.show', $admin) . '" class="mention-link bg-blue-100 text-blue-800 px-1 rounded hover:underline">@' . $adminName . '</a>';
                }

                return '@' . $adminName;
            },
            $description
        );
    }

    public function updateAssignment(LeadModel $lead, Request $request)
    {
        $request->validate([
            'assign_id' => 'required|exists:admins,id'
        ]);

        $lead->assigned_to = $request->assign_id;
        $lead->save();

        $lead->notes()->create([
            'admin_id'  => auth('admin')->id(),
            'note'      => auth('admin')->name . " Assigned Lead to " . $request->assign_name,
            'created'   => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment updated successfully'
        ]);
    }
}
