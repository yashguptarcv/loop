<?php

namespace Modules\Whatsapp\Services;

use Modules\Whatsapp\Models\WhatsAppMessage;
use Modules\Whatsapp\Models\WhatsAppTemplate;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use App\Events\WhatsAppTemplateSent;

class WhatsAppService
{
    protected $client;
    protected $apiUrl;
    protected $accessToken;
    protected $phoneNumberId;
    protected $businessAccountId;

    public function __construct()
    {
        $this->client            = new Client();
        $this->apiUrl            = 'https://graph.facebook.com/v23.0/';
        $this->accessToken       = fn_get_setting('general.whatsapp.access_token');
        $this->phoneNumberId     = fn_get_setting('general.whatsapp.phone_number');
        $this->businessAccountId = fn_get_setting('general.whatsapp.business_account_id');
    }

    /**
     * Upload media file to WhatsApp and get media ID
     */
    public function uploadMediaFile(UploadedFile $file, string $type = 'image'): array
    {
        try {
            // Validate file exists and is readable

            if (!$file->isValid()) {
                throw new \Exception('Invalid file upload: ' . $file->getErrorMessage());
            }

            // Get file information
            $filePath = $file->getRealPath();
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            Log::info('Attempting to upload media file', [
                'filename' => $fileName,
                'size' => $fileSize,
                'mime_type' => $mimeType,
                'type' => $type,
                'phone_number_id' => $this->phoneNumberId
            ]);

            // Validate file size limits
            $maxSizes = [
                'image' => 5 * 1024 * 1024, // 5MB
                'video' => 16 * 1024 * 1024, // 16MB
                'document' => 100 * 1024 * 1024, // 100MB
            ];

            if (isset($maxSizes[$type]) && $fileSize > $maxSizes[$type]) {
                throw new \Exception("File size ({$fileSize} bytes) exceeds maximum allowed for {$type} ({$maxSizes[$type]} bytes)");
            }

            // Validate MIME types
            $allowedMimeTypes = [
                'image' => ['image/jpeg', 'image/png'],
                'video' => ['video/mp4', 'video/3gpp'],
                'document' => ['application/pdf'],
            ];

            if (isset($allowedMimeTypes[$type]) && !in_array($mimeType, $allowedMimeTypes[$type])) {
                throw new \Exception("MIME type {$mimeType} not allowed for {$type}. Allowed: " . implode(', ', $allowedMimeTypes[$type]));
            }

            // Read file contents
            $mediaContent = file_get_contents($filePath);
            if ($mediaContent === false) {
                throw new \Exception('Failed to read file contents');
            }

            Log::info('File read successfully, uploading to WhatsApp', [
                'content_length' => strlen($mediaContent),
                'api_url' => $this->apiUrl . $this->phoneNumberId . '/media'
            ]);

            // Upload to WhatsApp
            $response = $this->client->post(
                $this->apiUrl . $this->phoneNumberId . '/media',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                    ],
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => $mediaContent,
                            'filename' => $fileName,
                            'headers' => [
                                'Content-Type' => $mimeType
                            ]
                        ],
                        [
                            'name' => 'type',
                            'contents' => $type
                        ],
                        [
                            'name' => 'messaging_product',
                            'contents' => 'whatsapp'
                        ]
                    ],
                    'timeout' => 60, // Increase timeout for large files
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            Log::info('WhatsApp media upload response', [
                'status_code' => $response->getStatusCode(),
                'response_body' => $responseBody
            ]);

            if (!isset($responseBody['id'])) {
                throw new \Exception('No media ID returned from WhatsApp API. Response: ' . json_encode($responseBody));
            }

            Log::info('Media uploaded successfully', [
                'media_id' => $responseBody['id'],
                'original_filename' => $fileName
            ]);

            return [
                'success' => true,
                'media_id' => $responseBody['id'],
                'data' => $responseBody
            ];
        } catch (GuzzleException $e) {
            $errorResponse = null;
            $statusCode = null;

            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            $errorMessage = $errorResponse['error']['message'] ?? $e->getMessage();
            $errorCode = $errorResponse['error']['code'] ?? 'unknown';
            $errorType = $errorResponse['error']['type'] ?? 'unknown';

            Log::error('WhatsApp media upload error', [
                'error_message' => $errorMessage,
                'error_code' => $errorCode,
                'error_type' => $errorType,
                'status_code' => $statusCode,
                'file' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'full_error_response' => $errorResponse,
                'exception_message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $errorMessage,
                'error_code' => $errorCode,
                'error_type' => $errorType,
                'status_code' => $statusCode,
                'error_details' => $errorResponse
            ];
        } catch (\Exception $e) {
            Log::error('Media upload general error', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName() ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_details' => null
            ];
        }
    }

    /**
     * Upload media from URL to WhatsApp and get media ID
     */
    public function uploadMediaFromUrl(string $mediaUrl, string $type = 'image'): array
    {
        try {
            Log::info('Attempting to upload media from URL', [
                'url' => $mediaUrl,
                'type' => $type
            ]);

            // First, download the media file
            $mediaResponse = $this->client->get($mediaUrl, ['timeout' => 30]);
            $mediaContent = $mediaResponse->getBody()->getContents();

            // Determine the MIME type based on the file extension or content type
            $mimeType = $this->getMimeTypeFromUrl($mediaUrl);
            $fileName = basename(parse_url($mediaUrl, PHP_URL_PATH));

            Log::info('Media downloaded from URL', [
                'content_length' => strlen($mediaContent),
                'mime_type' => $mimeType,
                'filename' => $fileName
            ]);

            // Upload to WhatsApp
            $response = $this->client->post(
                $this->apiUrl . $this->phoneNumberId . '/media',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                    ],
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => $mediaContent,
                            'filename' => $fileName,
                            'headers' => [
                                'Content-Type' => $mimeType
                            ]
                        ],
                        [
                            'name' => 'type',
                            'contents' => $type
                        ],
                        [
                            'name' => 'messaging_product',
                            'contents' => 'whatsapp'
                        ]
                    ],
                    'timeout' => 60,
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            Log::info('Media uploaded successfully from URL', [
                'media_id' => $responseBody['id'] ?? null,
                'original_url' => $mediaUrl,
                'response' => $responseBody
            ]);

            if (!isset($responseBody['id'])) {
                throw new \Exception('No media ID returned from WhatsApp API. Response: ' . json_encode($responseBody));
            }

            return [
                'success' => true,
                'media_id' => $responseBody['id'],
                'data' => $responseBody
            ];
        } catch (GuzzleException $e) {
            $errorResponse = null;
            $statusCode = null;

            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            }

            $errorMessage = $errorResponse['error']['message'] ?? $e->getMessage();

            Log::error('Media upload from URL error', [
                'error' => $errorMessage,
                'status_code' => $statusCode,
                'media_url' => $mediaUrl,
                'error_response' => $errorResponse
            ]);

            return [
                'success' => false,
                'error' => $errorMessage,
                'error_details' => $errorResponse
            ];
        } catch (\Exception $e) {
            Log::error('Media upload from URL general error', [
                'error' => $e->getMessage(),
                'media_url' => $mediaUrl
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_details' => null
            ];
        }
    }

    /**
     * Get MIME type from URL
     */
    private function getMimeTypeFromUrl(string $url): string
    {
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));

        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'mp4' => 'video/mp4',
            '3gp' => 'video/3gpp',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }



    /**
     * Send a text message and store in database
     */
    public function sendTextMessage(string $recipient, string $message, ?string $recipientName = null): array
    {
        // Create database record
        $messageRecord = WhatsAppMessage::create([
            'recipient_phone' => $this->formatPhoneNumber($recipient),
            'recipient_name' => $recipientName,
            'message_type' => 'text',
            'message_content' => $message,
            'status' => 'pending'
        ]);

        try {
            $response = $this->client->post(
                $this->apiUrl . $this->phoneNumberId . '/messages',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'messaging_product' => 'whatsapp',
                        'recipient_type' => 'individual',
                        'to' => $this->formatPhoneNumber($recipient),
                        'type' => 'text',
                        'text' => [
                            'preview_url' => false,
                            'body' => $message
                        ]
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Update database record with success
            $messageRecord->update([
                'status' => 'sent',
                'whatsapp_message_id' => $responseBody['messages'][0]['id'] ?? null,
                'api_response' => $responseBody,
                'sent_at' => Carbon::now()
            ]);

            Log::info('WhatsApp message sent successfully', [
                'message_id' => $messageRecord->id,
                'recipient' => $recipient,
                'response' => $responseBody
            ]);

            return [
                'success' => true,
                'data' => $responseBody,
                'message_record' => $messageRecord
            ];
        } catch (GuzzleException $e) {
            // Update database record with error
            $messageRecord->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            Log::error('WhatsApp API error', [
                'message_id' => $messageRecord->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message_record' => $messageRecord
            ];
        }
    }



    /**
     * Send a template message and store in database
     *
     */
    public function sendTemplateMessage(string $recipient, string $templateName, string $language = 'en_US', array $components = [], ?string $recipientName = null): array
    {
        // Create database record
        $messageRecord = WhatsAppMessage::create([
            'recipient_phone' => $this->formatPhoneNumber($recipient),
            'recipient_name' => $recipientName,
            'message_type' => 'template',
            'message_content' => "Template: {$templateName}",
            'template_name' => $templateName,
            'template_parameters' => $components,
            'status' => 'pending'
        ]);

        try {
            $payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhoneNumber($recipient),
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => $language
                    ]
                ]
            ];

            if (!empty($components)) {
                $payload['template']['components'] = $components;
            }

            $response = $this->client->post(
                $this->apiUrl . $this->phoneNumberId . '/messages',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $payload
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Update database record with success
            $messageRecord->update([
                'status' => 'sent',
                'whatsapp_message_id' => $responseBody['messages'][0]['id'] ?? null,
                'api_response' => $responseBody,
                'sent_at' => Carbon::now()
            ]);

            Log::info('WhatsApp template message sent successfully', [
                'message_id' => $messageRecord->id,
                'template' => $templateName,
                'recipient' => $recipient
            ]);

            return [
                'success' => true,
                'data' => $responseBody,
                'message_record' => $messageRecord
            ];
        } catch (GuzzleException $e) {
            // Update database record with error
            $messageRecord->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            Log::error('WhatsApp template API error', [
                'message_id' => $messageRecord->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message_record' => $messageRecord
            ];
        }
    }

    /**
     * Send an image message and store in database
     */
    public function sendImageMessage(string $recipient, string $imageUrl, ?string $caption = null, ?string $recipientName = null): array
    {
        // Create database record
        $messageRecord = WhatsAppMessage::create([
            'recipient_phone' => $this->formatPhoneNumber($recipient),
            'recipient_name' => $recipientName,
            'message_type' => 'image',
            'message_content' => $caption ?? 'Image message',
            'media_url' => $imageUrl,
            'media_caption' => $caption,
            'status' => 'pending'
        ]);

        try {
            $payload = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhoneNumber($recipient),
                'type' => 'image',
                'image' => [
                    'link' => $imageUrl,
                ]
            ];

            if ($caption) {
                $payload['image']['caption'] = $caption;
            }

            $response = $this->client->post(
                $this->apiUrl . $this->phoneNumberId . '/messages',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $payload
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Update database record with success
            $messageRecord->update([
                'status' => 'sent',
                'whatsapp_message_id' => $responseBody['messages'][0]['id'] ?? null,
                'api_response' => $responseBody,
                'sent_at' => Carbon::now()
            ]);

            Log::info('WhatsApp image message sent successfully', [
                'message_id' => $messageRecord->id,
                'recipient' => $recipient
            ]);

            return [
                'success' => true,
                'data' => $responseBody,
                'message_record' => $messageRecord
            ];
        } catch (GuzzleException $e) {
            // Update database record with error
            $messageRecord->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            Log::error('WhatsApp image API error', [
                'message_id' => $messageRecord->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message_record' => $messageRecord
            ];
        }
    }

    /**
     * Create a new WhatsApp message template
     */
    public function createTemplate(array $templateData): array
    {
        try {
            // Format the template data for the API
            $apiTemplateData = $this->formatTemplateDataForApi($templateData);

            // Make the API request to create the template
            $response = $this->client->post(
                $this->apiUrl . $this->businessAccountId . '/message_templates',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $apiTemplateData,
                    'timeout' => 30
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Create or update the template record in the database
            $template = WhatsAppTemplate::updateOrCreate(
                ['name' => $templateData['name']],
                [
                    'category' => $templateData['category'],
                    'language' => $templateData['language'],
                    'header_text' => $templateData['header_text'] ?? null,
                    'header_type' => $templateData['header_type'] ?? null,
                    'header_image_url' => $templateData['header_image_url'] ?? null,
                    'header_video_url' => $templateData['header_video_url'] ?? null,
                    'header_document_url' => $templateData['header_document_url'] ?? null,
                    'body_text' => $templateData['body_text'],
                    'body_examples' => $templateData['body_examples'] ?? null,
                    'footer_text' => $templateData['footer_text'] ?? null,
                    'buttons' => $templateData['buttons'] ?? null,
                    'status' => 'pending',
                    'template_id' => $responseBody['id'] ?? null,
                    'api_response' => $responseBody
                ]
            );

            return [
                'success' => true,
                'data' => $responseBody,
                'template' => $template
            ];
        } catch (GuzzleException $e) {
            $errorResponse = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true) : null;
            $errorMessage = $errorResponse['error']['message'] ?? $e->getMessage();

            Log::error('WhatsApp template creation error', [
                'error' => $errorMessage,
                'template_data' => $templateData,
                'error_response' => $errorResponse
            ]);

            return [
                'success' => false,
                'error' => $errorMessage,
                'error_details' => $errorResponse
            ];
        } catch (\Exception $e) {
            Log::error('Template creation general error', [
                'error' => $e->getMessage(),
                'template_data' => $templateData
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'error_details' => null
            ];
        }
    }

    /**
     * Get all templates for the WhatsApp Business Account
     */
    public function getTemplates(): array
    {
        try {
            $response = $this->client->get(
                $this->apiUrl . $this->businessAccountId . '/message_templates',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                    ],
                    'query' => [
                        'limit' => 100
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => $responseBody['data'] ?? []
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get template details by ID
     */
    public function getTemplateDetails(string $templateId): array
    {
        try {
            $response = $this->client->get(
                $this->apiUrl . $templateId,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'data' => $responseBody
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete a template
     */
    public function deleteTemplate(string $templateName): array
    {
        try {
            $response = $this->client->delete(
                $this->apiUrl . $this->businessAccountId . '/message_templates',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'name' => $templateName
                    ]
                ]
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Delete the template from the database
            WhatsAppTemplate::where('name', $templateName)->delete();

            return [
                'success' => true,
                'data' => $responseBody
            ];
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number to remove any formatting
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If phone starts with 0, remove it (for international format)
        if (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }

        return $phone;
    }

    /**
     * Format template data for the WhatsApp API
     */
    private function formatTemplateDataForApi(array $templateData): array
    {
        $components = [];

        // Add header component if provided
        if (!empty($templateData['header_type'])) {
            $headerComponent = [
                'type' => 'HEADER',
                'format' => strtoupper($templateData['header_type']),
            ];

            if ($templateData['header_type'] === 'text' && !empty($templateData['header_text'])) {
                $headerComponent['text'] = $templateData['header_text'];
            } elseif (in_array($templateData['header_type'], ['image', 'video', 'document', 'carousel'])) {
                // Handle media headers - upload media first and get media ID
                $mediaId = null;

                // Check if we have a file upload
                if (!empty($templateData['header_file']) && !empty($templateData['header_media_type'])) {
                    Log::info('Processing header file upload', [
                        'file_name' => $templateData['header_file']->getClientOriginalName(),
                        'media_type' => $templateData['header_media_type']
                    ]);

                    // Upload the file and get media ID
                    $uploadResult = $this->uploadMediaFile(
                        $templateData['header_file'],
                        $templateData['header_media_type']
                    );

                    if ($uploadResult['success']) {
                        $mediaId = $uploadResult['media_id'];

                        Log::info('Media uploaded for template header', [
                            'media_id' => $mediaId,
                            'file' => $templateData['header_file']->getClientOriginalName(),
                            'type' => $templateData['header_media_type']
                        ]);
                    } else {
                        // If media upload fails, throw an exception with detailed error
                        $errorDetails = isset($uploadResult['error_details']) ? json_encode($uploadResult['error_details']) : 'No additional details';
                        throw new \Exception("Failed to upload media for header: " . $uploadResult['error'] . ". Details: " . $errorDetails);
                    }
                }
                // Fallback to URL if provided (for backward compatibility)
                elseif ($templateData['header_type'] === 'image' && !empty($templateData['header_image_url'])) {
                    $uploadResult = $this->uploadMediaFromUrl($templateData['header_image_url'], 'image');
                    if ($uploadResult['success']) {
                        $mediaId = $uploadResult['media_id'];
                    } else {
                        throw new \Exception("Failed to upload image from URL: " . $uploadResult['error']);
                    }
                } elseif ($templateData['header_type'] === 'video' && !empty($templateData['header_video_url'])) {
                    $uploadResult = $this->uploadMediaFromUrl($templateData['header_video_url'], 'video');
                    if ($uploadResult['success']) {
                        $mediaId = $uploadResult['media_id'];
                    } else {
                        throw new \Exception("Failed to upload video from URL: " . $uploadResult['error']);
                    }
                } elseif ($templateData['header_type'] === 'document' && !empty($templateData['header_document_url'])) {
                    $uploadResult = $this->uploadMediaFromUrl($templateData['header_document_url'], 'document');
                    if ($uploadResult['success']) {
                        $mediaId = $uploadResult['media_id'];
                    } else {
                        throw new \Exception("Failed to upload document from URL: " . $uploadResult['error']);
                    }
                }

                if ($mediaId) {
                    $headerComponent['example'] = [
                        'header_handle' => [$mediaId]
                    ];
                }
            }

            $components[] = $headerComponent;
        }

        // Add body component
        $bodyComponent = [
            'type' => 'BODY',
            'text' => $templateData['body_text']
        ];

        if (isset($templateData['body_examples']) && !empty($templateData['body_examples'])) {
            $bodyComponent['example'] = [
                'body_text' => [$templateData['body_examples']]
            ];
        }

        $components[] = $bodyComponent;

        // Add footer component
        if (!empty($templateData['footer_text'])) {
            $components[] = [
                'type' => 'FOOTER',
                'text' => $templateData['footer_text']
            ];
        }

        // Add buttons
        if (!empty($templateData['buttons']) && is_array($templateData['buttons'])) {
            $buttonComponent = [
                'type' => 'BUTTONS',
                'buttons' => []
            ];

            foreach ($templateData['buttons'] as $button) {
                if ($button['type'] === 'url') {
                    $buttonComponent['buttons'][] = [
                        'type' => 'URL',
                        'text' => $button['text'],
                        'url' => $button['url']
                    ];
                } elseif ($button['type'] === 'phone_number') {
                    $buttonComponent['buttons'][] = [
                        'type' => 'PHONE_NUMBER',
                        'text' => $button['text'],
                        'phone_number' => $button['phone_number']
                    ];
                } elseif ($button['type'] === 'quick_reply') {
                    $buttonComponent['buttons'][] = [
                        'type' => 'QUICK_REPLY',
                        'text' => $button['text']
                    ];
                }
            }

            $components[] = $buttonComponent;
        }

        return [
            'name' => $templateData['name'],
            'category' => strtoupper($templateData['category']),
            'language' => $templateData['language'],
            'components' => $components
        ];
    }

    /**
     * Sync templates from WhatsApp API to local database
     */
    public function syncTemplates(): array
    {
        $result = $this->getTemplates();

        if (!$result['success']) {
            return $result;
        }

        $apiTemplates = $result['data'];
        $syncedCount = 0;

        foreach ($apiTemplates as $apiTemplate) {
            // Get template details
            $detailsResult = $this->getTemplateDetails($apiTemplate['id']);

            if ($detailsResult['success']) {
                $templateDetails = $detailsResult['data'];

                // Extract components
                $headerText = null;
                $headerType = null;
                $bodyText = null;
                $footerText = null;
                $buttons = [];

                if (!empty($templateDetails['components'])) {
                    foreach ($templateDetails['components'] as $component) {
                        if ($component['type'] === 'HEADER') {
                            $headerText = $component['text'] ?? null;
                            $headerType = strtolower($component['format']) ?? 'text';
                        } elseif ($component['type'] === 'BODY') {
                            $bodyText = $component['text'] ?? '';
                        } elseif ($component['type'] === 'FOOTER') {
                            $footerText = $component['text'] ?? null;
                        } elseif ($component['type'] === 'BUTTONS' && !empty($component['buttons'])) {
                            foreach ($component['buttons'] as $button) {
                                $buttonData = [
                                    'type' => strtolower($button['type']),
                                    'text' => $button['text']
                                ];

                                if (isset($button['url'])) {
                                    $buttonData['url'] = $button['url'];
                                }

                                if (isset($button['phone_number'])) {
                                    $buttonData['phone_number'] = $button['phone_number'];
                                }

                                $buttons[] = $buttonData;
                            }
                        }
                    }
                }

                // Create or update template in database
                WhatsAppTemplate::updateOrCreate(
                    ['name' => $apiTemplate['name']],
                    [
                        'category' => strtolower($apiTemplate['category']),
                        'language' => $apiTemplate['language'],
                        'header_text' => $headerText,
                        'header_type' => $headerType,
                        'body_text' => $bodyText ?? 'No body content',
                        'footer_text' => $footerText,
                        'buttons' => !empty($buttons) ? $buttons : null,
                        'status' => strtolower($apiTemplate['status']),
                        'template_id' => $apiTemplate['id'],
                        'api_response' => $templateDetails,
                        'rejection_reason' => $apiTemplate['status'] === 'REJECTED' ? ($apiTemplate['quality_score']['reason'] ?? null) : null
                    ]
                );

                $syncedCount++;
            }
        }

        return [
            'success' => true,
            'message' => "{$syncedCount} templates synced successfully",
            'count' => $syncedCount
        ];
    }
}
