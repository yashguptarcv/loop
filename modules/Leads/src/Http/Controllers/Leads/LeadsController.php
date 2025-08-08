<?php

namespace Modules\Leads\Http\Controllers\Leads;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Leads\Models\LeadModel;
use Illuminate\Support\Facades\Validator;
use Modules\Leads\Models\LeadSourceModel;
use Modules\Leads\Models\LeadStatusModel;
use Modules\Leads\Models\LeadAttachmentModel;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $lead_statuses = LeadStatusModel::orderBy('sort')->get();
        $leads = LeadModel::with('status')->get();

        return view("leads::leads.index", compact('lead_statuses', 'leads'));
    }

    public function create()
    {
        $leadStatuses = LeadStatusModel::orderBy('sort')->get();
        $leadSources  = LeadSourceModel::where('is_active', '1')->get();
        $users = [];
        return view('leads::leads.lead-form', compact('leadStatuses', 'leadSources', 'users'));
    }
    
    public function edit($id)
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
            'tags'
        )->where('id', $id)->first();
        return view('leads::leads.lead-details', compact('lead'));
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
            'created_by' => 1,
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
            abort(404);
        }

        $path = storage_path('app/lead_attachments/' . $attachment->filename);

        if (!file_exists($path)) {
            abort(404);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Lead status updated successfully'
        ]);
    }
}
