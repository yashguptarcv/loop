<?php

namespace Modules\Whatsapp\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Whatsapp\DataView\WhatsappGrid;
use Modules\Whatsapp\Models\WhatsAppTemplate;
use Modules\Whatsapp\Services\WhatsAppService;
use Illuminate\Support\Facades\Validator; // Added for manual validation

class WhatsAppTemplateController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Display a listing of templates
     */
    public function index(Request $request): View
    {

        $lists = fn_datagrid(WhatsappGrid::class)->process();

        return view('whatsapp::whatsapp.index', compact('lists'));
    }

    /**
     * Show the form for creating a new template
     */
    public function create(): View
    {
        return view('whatsapp::whatsapp.create');
    }

    /**
     * Store a newly created template
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:512|regex:/^[a-z0-9_]+$/|unique:whatsapp_templates,name',
            'category' => 'required|string|in:marketing,utility,authentication',
            'language' => 'required|string',
            'header_type' => 'nullable|string|in:text,image,video,document,none',
            'header_text' => 'nullable|string|max:60',
            'header_image' => 'nullable|file|mimes:jpeg,png|max:5120', // 5MB max
            'header_video' => 'nullable|file|mimes:mp4,3gpp|max:16384', // 16MB max
            'header_document' => 'nullable|file|mimes:pdf|max:102400', // 100MB max
            'body_text' => 'required|string|max:1024',
            'body_examples' => 'nullable|string',
            'footer_text' => 'nullable|string|max:60',
            'button_type' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_url' => 'nullable|array',
            'button_phone' => 'nullable|array',
        ]);

        // Format buttons data
        $buttons = [];
        if ($request->filled('button_type')) {
            foreach ($request->button_type as $index => $type) {
                if (empty($type) || empty($request->button_text[$index])) {
                    continue;
                }
                $button = [
                    'type' => $type,
                    'text' => $request->button_text[$index]
                ];
                if ($type === 'url' && !empty($request->button_url[$index])) {
                    $button['url'] = $request->button_url[$index];
                } elseif ($type === 'phone_number' && !empty($request->button_phone[$index])) {
                    $button['phone_number'] = $request->button_phone[$index];
                }
                $buttons[] = $button;
            }
        }

        // Prepare template data
        $templateData = [
            'name' => $request->name,
            'category' => $request->category,
            'language' => $request->language,
            'body_text' => $request->body_text,
            'buttons' => $buttons,
        ];

        // Add header if provided
        if ($request->header_type !== 'none') {
            $templateData['header_type'] = $request->header_type;
            if ($request->header_type === 'text' && $request->filled('header_text')) {
                $templateData['header_text'] = $request->header_text;
            } elseif ($request->header_type === 'image' && $request->hasFile('header_image')) {
                $templateData['header_file'] = $request->file('header_image');
                $templateData['header_media_type'] = 'image';
            } elseif ($request->header_type === 'video' && $request->hasFile('header_video')) {
                $templateData['header_file'] = $request->file('header_video');
                $templateData['header_media_type'] = 'video';
            } elseif ($request->header_type === 'document' && $request->hasFile('header_document')) {
                $templateData['header_file'] = $request->file('header_document');
                $templateData['header_media_type'] = 'document';
            }
        }

        // Add footer if provided
        if ($request->filled('footer_text')) {
            $templateData['footer_text'] = $request->footer_text;
        }

        // Add body examples if provided
        if ($request->filled('body_examples')) {
            $templateData['body_examples'] = array_map('trim', explode(',', $request->body_examples));
        }

        // Create the template
        $result = $this->whatsAppService->createTemplate($templateData);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Template created successfully and submitted for approval.',
                'redirect_url' => route('admin.whatsapp.templates.index'),
            ]);
        }

        return response()->json(['errors' => [
                    'message' => 'Failed to create template: ' . $result['error'],
                    'redirect_url' => route('admin.whatsapp.templates.create')
                ]
            ]);
    }

    /**
     * Display the specified template
     */
    public function show(WhatsAppTemplate $template): View
    {
        return view('whatsapp::whatsapp.show', compact('template'));
    }

    /**
     * Delete the specified template
     */
    public function destroy(WhatsAppTemplate $template): RedirectResponse
    {
        $result = $this->whatsAppService->deleteTemplate($template->name);

        if ($result['success']) {
            // Also remove any associated event mappings
            DB::table('whatsapp_event_templates')->where('template_name', $template->name)->delete();
            return redirect()->route('admin.whatsapp.templates.index')
                ->with('success', 'Template deleted successfully.');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete template: ' . $result['error']);
    }

    public function bulkDelete(Request $request) {

    }

    /**
     * Sync templates from WhatsApp API
     */
    public function sync()
    {
        $result = $this->whatsAppService->syncTemplates();

        if (!empty($result['success']) && $result['success']) {
            return redirect()->route('admin.whatsapp.templates.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', 'Failed to sync templates: ' . $result['error']);
    }

    /**
     * Store the mapping between an event key and a WhatsApp template name.
     */
    public function storeEventMapping(Request $request): RedirectResponse
    {
        $rules = [
            'selected_template_name' => 'required|string|exists:whatsapp_templates,name',
            'event_key_type' => 'required|in:new,existing',
            'new_event_key' => [
                'required_if:event_key_type,new',
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z_]+$/', // Only lowercase letters and underscores
                Rule::unique('whatsapp_event_templates', 'event_key')->where(function ($query) use ($request) {
                    // Only check uniqueness if event_key_type is 'new'
                    if ($request->input('event_key_type') === 'new') {
                        $query->where('event_key', $request->input('new_event_key'));
                    }
                }),
            ],
            'existing_event_key' => 'required_if:event_key_type,existing|nullable|string|exists:whatsapp_event_templates,event_key',
        ];

        $messages = [
            'new_event_key.regex' => 'The new event key must only contain lowercase letters and underscores.',
            'new_event_key.unique' => 'This event key already exists. Please choose a different one or select an existing key.',
            'new_event_key.required_if' => 'The new event key is required when creating a new event key.',
            'existing_event_key.required_if' => 'Please select an existing event key.',
            'selected_template_name.required' => 'Please select a admin.whatsapp.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($request->input('event_key_type') === 'new') {
                if ($errors->has('new_event_key')) {
                    if ($errors->first('new_event_key') === $messages['new_event_key.regex']) {
                        return redirect()->route('admin.whatsapp.templates.index')
                            ->with('error', $messages['new_event_key.regex']);
                    } elseif ($errors->first('new_event_key') === $messages['new_event_key.unique']) {
                        return redirect()->route('admin.whatsapp.templates.index')
                            ->with('error', $messages['new_event_key.unique']);
                    }
                }
            }
        }

        $templateName = $request->input('selected_template_name');
        $eventKey = $request->input('event_key_type') === 'new'
            ? $request->input('new_event_key')
            : $request->input('existing_event_key');

        try {
            // Check if a mapping already exists for this template and event key
            $existingMapping = DB::table('whatsapp_event_templates')
                ->where('template_name', $templateName)
                ->where('event_key', $eventKey)
                ->first();

            if ($existingMapping) {
                return redirect()->route('admin.whatsapp.templates.index')->with('error', 'This template is already assigned to this event key.');
            }

            DB::table('whatsapp_event_templates')->updateOrInsert(
                ['event_key' => $eventKey],
                ['template_name' => $templateName, 'created_at' => now(), 'updated_at' => now()]
            );

            return redirect()->route('admin.whatsapp.templates.index')
                ->with('success', "Template '{$templateName}' successfully assigned to event key '{$eventKey}'.");
        } catch (\Exception $e) {
            return redirect()->route('admin.whatsapp.templates.index')
                ->with('error', 'Failed to assign template to event key: ' . $e->getMessage());
        }
    }
}
