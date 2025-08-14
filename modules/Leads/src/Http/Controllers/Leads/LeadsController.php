<?php

namespace Modules\Leads\Http\Controllers\Leads;

use Illuminate\Http\Request;
use Modules\Acl\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Modules\Leads\Models\LeadModel;
use Modules\Meetings\Models\Meeting;
use Illuminate\Support\Facades\Validator;
use Modules\Leads\Models\LeadSourceModel;
use Modules\Leads\Models\LeadStatusModel;
use Modules\Leads\Models\LeadAttachmentModel;
use Modules\Meetings\Services\GoogleCalendarService;

class LeadsController extends Controller
{
    protected $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index(Request $request)
    {
        $lead_statuses = LeadStatusModel::orderBy('sort')->get();
        if (fn_get_setting('general.settings.lead_assigned_user') == auth('admin')->id()) {
            $leads = LeadModel::with('status')->orderBy('updated_at')->get();
        } else {
            $leads = LeadModel::with('status')->where('assigned_to', auth('admin')->id())->orderBy('updated_at')->get();
        }

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
        $leads = LeadModel::find($id);
        $leadStatuses = LeadStatusModel::orderBy('sort')->get();
        $leadSources  = LeadSourceModel::where('is_active', '1')->get();
        $users = [];
        return view('admin::leads.lead.form', compact('leads', 'leadStatuses', 'leadSources', 'users'));
    }

    public function details(Request $request, $id = null)
    {

        $lead = LeadModel::with(
            'status',
            'source',
            'assignedTo',
            'tags',
            'activities',
            'notes',
            'attachments',
            'tags',
            'application'
        )->where('id', $id)->first();

        $admins = Admin::get('id', 'name');
        return view('leads::leads.lead-details', compact('lead', 'admins'));
    }


    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }
        // Create the lead
        $lead = LeadModel::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'company' => $request['company'],
            'status_id' => fn_get_setting('general.settings.default_lead_status'),
            'source_id' => $request['source_id'],
            'assigned_to' => fn_get_setting('general.settings.lead_assigned_user'),
            'value' => $request['value'],
            'description' => $request['description'],
            'industries'    => $request['industry'] ?? '',
            'website'       => $request['website'] ?? '',
            'address'       => $request['address'],
            'address_2'     => $request['address_2'] ?? '',
            'country'       => $request['country'],
            'state'         => $request['state'],
            'city'          => $request['city'],
            'postal_code'   => $request['postal_code'],
            'custom_fields' => $request['custom_fields'] ?? '',
            'created_by' => auth('admin')->id(),
        ]);

        $lead->notes()->create([
            'admin_id'  => auth('admin')->id(),
            'note'      => "Lead created by " . auth('admin')->name,
            'created'   => now()
        ]);

        // Handle tags if provided
        if (!empty($request['tags'])) {
            $tags = array_map('trim', explode(',', $request['tags']));
            $lead->syncTags($tags);
        }

        // Handle file uploads
        $this->handleImages($request, $lead);

        return response()->json([
            'success' => true,
            'message' => 'Lead created successfully!',
            'redirect_url' => route('admin.leads.index')
        ]);
    }

    public function update(Request $request, LeadModel $lead)
    {
        $validated = $this->validateRequest($request, $lead);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

        // Update the lead
        $lead->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'company' => $request['company'],
            'status_id' => $request['status_id'],
            'source_id' => $request['source_id'],
            'assigned_to' => $request['assigned_to'],
            'value' => $request['value'],
            'description' => $request['description'],
            'industries'    => $request['industry'] ?? '',
            'website'       => $request['website'] ?? '',
            'address'       => $request['address'],
            'address_2'     => $request['address_2'] ?? '',
            'country'       => $request['country'],
            'state'         => $request['state'],
            'city'          => $request['city'],
            'postal_code'   => $request['postal_code'],
            'custom_fields' => $request['custom_fields'] ?? '',
        ]);

        // Handle tags if provided
        if (!empty($request['tags'])) {
            $tags = array_unique(array_map('trim', explode(',', $request['tags'])));
            $lead->syncTags($tags);
        }


        // Handle file uploads
        $this->handleImages($request, $lead);


        return response()->json([
            'success' => true,
            'message' => 'Lead updated successfully!',
            'redirect_url' => route('admin.leads.show', $lead)
        ]);
    }

    public function downloadAttachment(LeadModel $lead, LeadAttachmentModel $attachment)
    {
        // Verify the attachment belongs to the lead
        if ($attachment->lead_id !== $lead->id) {
            session()->flash('error', 'Unable to download attachment');
            return redirect()->route('admin.leads.details', $lead->id);
        }

        $path = storage_path('app/lead_attachments/' . $attachment->filename);

        if (!file_exists($path)) {
            session()->flash('error', 'Unable to download attachment');
            return redirect()->route('admin.leads.details', $lead->id);
        }

        $lead->notes()->create([
            'admin_id'  => auth('admin')->id(),
            'note'      => auth('admin')->name . " download attachments ",
            'created'   => now()
        ]);

        return response()->download($path, $attachment->original_filename);
    }

    protected function validateRequest(Request $request, $lead = null)
    {
        // |unique:leads,email' . ($lead ? ',' . $lead->id : ''),
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'source_id' => 'nullable|exists:lead_sources,id',
            'value' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'images.*' => 'nullable|file|max:5120', // 5MB
        ]);
    }

    protected function handleImages(Request $request, LeadModel $lead)
    {
        if ($request->hasFile('images')) {
            
            foreach ($request->file('images') as $file) {
                $originalFilename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = LeadAttachmentModel::generateFilename($extension);
                $path = $file->storeAs('lead_attachments', $filename);

                LeadAttachmentModel::create([
                    'lead_id' => $lead->id,
                    'admin_id' => auth('admin')->id(),
                    'filename' => $filename,
                    'original_filename' => $originalFilename,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }
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

        // $lead->notes()->create([
        //     'admin_id'  => auth('admin')->id(),
        //     'note'      => auth('admin')->name . " changed lead status to " . $request->status_id,
        //     'created'   => now()
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Lead status updated successfully'
        ]);
    }

    // lead activity

    public function storeActivity(Request $request, LeadModel $lead)
    {
        $validated = Validator::make($request->all(), [
            'type' => 'required|in:general,call,email,meeting,schedule_meeting',
            'description' => 'required|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'outcome' => 'nullable|in:positive,neutral,negative,follow_up',
            'meeting_date'  => 'nullable'
        ]);

        
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }

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
        $this->handleImages($request, $lead);
        // $lead->notes()->create([
        //     'admin_id'  => auth('admin')->id(),
        //     'note'      => auth('admin')->name . " Added message",
        //     'created'   => now()
        // ]);

        if (!empty($request['meeting_date'])) {

            // Parse the meeting date and automatically set end time 2 hours later
            $startTime = Carbon::parse($request['meeting_date']);
            $endTime = $startTime->copy()->addMinute(30);
            $meeting = Meeting::create([
                'title' => auth('admin')->name . " Schedule a meeting with " . $lead->name,
                'description' => $description,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'location' => '',
                'color'    => '##0099cc',
                'admin_id' => auth('admin')->id(),
            ]);

            // Only sync if user has Google auth        
            try {
                $event = $this->calendarService->createEvent($meeting);
                $meeting->update([
                    'google_event_id' => $event->id,
                    'google_calendar_id' => 'primary',
                ]);
                $lead->notes()->create([
                    'admin_id'  => auth('admin')->id(),
                    'note'      => auth('admin')->name . " Schedule a meeting on " . $request['meeting_date'] . "\n, Google meeting ID: $event->id",
                    'created'   => now()
                ]);
                session()->flash('success', 'Meeting created successfully');
            } catch (\InvalidArgumentException $e) {
                // Handle invalid date error
                session()->flash('error', 'Unable to create meeting, try after some time \n' . $e->getMessage());
            } catch (\Exception $e) {
                session()->flash('error', 'Unable to create meeting on Google Calendar: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Activity added successfully',
            'activity' => $activity,
            'redirect_url' => route('admin.leads.details', $lead->id)
        ]);
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

    // In your AdminController or UserController
    public function searchAdmins(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $admins = Admin::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'avatar' => $admin->avatar_url, // Make sure this accessor exists
                    'email' => $admin->email
                ];
            });

        return response()->json($admins);
    }

    // app/Http/Controllers/LeadController.php
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
