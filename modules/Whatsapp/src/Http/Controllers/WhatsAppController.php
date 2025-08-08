<?php

namespace Modules\Whatsapp\Http\Controllers;

use Modules\Whatsapp\Models\WhatsAppMessage;
use Modules\Whatsapp\Services\WhatsAppService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Modules\Whatsapp\Models\WhatsAppTemplate;

class WhatsAppController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Show the main dashboard
     */
    public function index(): View
    {
        $templates = WhatsAppTemplate::all();
        return view('whatsapp::dashboard', compact('templates'));
    }

    /**
     * Send a text message
     */
    public function sendTextMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'recipient_phone' => 'required|string|min:10',
            'recipient_name' => 'nullable|string|max:255',
            'message' => 'required|string|max:4096',
        ]);


        $result = $this->whatsAppService->sendTextMessage(
            $request->recipient_phone,
            $request->message,
            $request->recipient_name
        );


        if ($result['success']) {
            return redirect()->back()->with('success', 'WhatsApp message sent successfully!');
        }

        return redirect()->back()
            ->with('error', 'Failed to send WhatsApp message: ' . $result['error'])
            ->withInput();
    }

    /**
     * Send a template message
     */
    public function sendTemplateMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'recipient_phone' => 'required|string|min:10',
            'recipient_name' => 'nullable|string|max:255',
            'template_name' => 'required|string',
            'language' => 'required|string',
            'parameters' => 'nullable|array',
            'header_type' => 'nullable|string|in:text,image,video,document',
            'header_value' => 'nullable|string', // URL or text depending on type
        ]);


        $components = [];

        // Add HEADER (image/text) if provided
        if ($request->filled('header_type') && $request->filled('header_value')) {
            if ($request->header_type === 'image') {
                $components[] = [
                    'type' => 'header',
                    'parameters' => match ($request->header_type) {
                        'text' => [['type' => 'text', 'text' => $request->header_value]],
                        'image' => [['type' => 'image', 'image' => ['link' => $request->header_value]]],
                        'video' => [['type' => 'video', 'video' => ['link' => $request->header_value]]],
                        'document' => [['type' => 'document', 'document' => ['link' => $request->header_value]]],
                        default => [],
                    },
                ];
            } elseif ($request->header_type === 'text') {
                $components[] = [
                    'type' => 'header',
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => $request->header_value
                        ]
                    ]
                ];
            }
            // Add more types like 'video', 'document' as needed
        }

        // Add BODY parameters if present
        if ($request->filled('parameters')) {
            $parameters = array_filter($request->parameters);
            if (!empty($parameters)) {
                $components[] = [
                    'type' => 'body',
                    'parameters' => array_map(function ($param) {
                        return ['type' => 'text', 'text' => $param];
                    }, array_values($parameters))
                ];
            }
        }

        $result = $this->whatsAppService->sendTemplateMessage(
            $request->recipient_phone,
            $request->template_name,
            $request->language,
            $components,
            $request->recipient_name
        );

        if ($result['success']) {
            return redirect()->back()->with('success', 'WhatsApp template message sent successfully!');
        }

        return redirect()->back()
            ->with('error', 'Failed to send WhatsApp template message: ' . $result['error'])
            ->withInput();
    }

    /**
     * Send an image message
     */
    public function sendImageMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'recipient_phone' => 'required|string|min:10',
            'recipient_name' => 'nullable|string|max:255',
            'image_url' => 'required|url',
            'caption' => 'nullable|string|max:1024',
        ]);

        $result = $this->whatsAppService->sendImageMessage(
            $request->recipient_phone,
            $request->image_url,
            $request->caption,
            $request->recipient_name
        );

        if ($result['success']) {
            return redirect()->back()->with('success', 'WhatsApp image message sent successfully!');
        }

        return redirect()->back()
            ->with('error', 'Failed to send WhatsApp image message: ' . $result['error'])
            ->withInput();
    }

    /**
     * API endpoint to send text message
     */
    public function apiSendTextMessage(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
            'name' => 'nullable|string',
        ]);

        // dd($request->all());

        $result = $this->whatsAppService->sendTextMessage(
            $request->phone,
            $request->message,
            $request->name
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp message sent successfully',
                'data' => $result['data'],
                'message_id' => $result['message_record']->id
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send WhatsApp message',
            'error' => $result['error']
        ], 500);
    }

    /**
     * Get message details
     */
    public function getMessageDetails($id): JsonResponse
    {
        $message = WhatsAppMessage::find($id);

        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }

    /**
     * Webhook to receive WhatsApp status updates
     */
    public function webhook(Request $request): JsonResponse
    {
        // Handle verification request from Meta
        if ($request->has('hub_mode') && $request->input('hub_mode') === 'subscribe') {
            $verifyToken = env('WHATSAPP_VERIFY_TOKEN');

            if ($request->input('hub_verify_token') === $verifyToken) {
                return response()->json($request->input('hub_challenge'));
            }

            return response()->json('Verification failed', 403);
        }

        // Process incoming webhook data
        $payload = $request->all();

        // Log the incoming webhook for debugging
        Log::info('WhatsApp webhook received', $payload);

        // Process status updates
        if (isset($payload['entry'])) {
            foreach ($payload['entry'] as $entry) {
                if (isset($entry['changes'])) {
                    foreach ($entry['changes'] as $change) {
                        if ($change['field'] === 'messages') {
                            $this->processWebhookData($change['value']);
                        }
                    }
                }
            }
        }

        return response()->json('OK');
    }

    /**
     * Process webhook data to update message status
     */
    private function processWebhookData(array $data): void
    {
        // Process message status updates
        if (isset($data['statuses'])) {
            foreach ($data['statuses'] as $status) {
                $messageId = $status['id'];
                $statusValue = $status['status'];

                // Update message status in database
                WhatsAppMessage::where('whatsapp_message_id', $messageId)
                    ->update(['status' => $statusValue]);

                Log::info('Message status updated', [
                    'message_id' => $messageId,
                    'status' => $statusValue
                ]);
            }
        }

        // Process incoming messages (if you want to handle replies)
        if (isset($data['messages'])) {
            foreach ($data['messages'] as $message) {
                Log::info('Incoming message received', $message);
                // Handle incoming messages here if needed
            }
        }
    }
}
