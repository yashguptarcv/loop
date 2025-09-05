<?php

namespace Modules\Whatsapp\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'name',
        'category',
        'language',
        'header_text',
        'header_type',
        'header_image_url',
        'header_video_url',
        'header_document_url',
        'body_text',
        'body_examples',
        'footer_text',
        'buttons',
        'status',
        'template_id',
        'api_response',
        'rejection_reason'
    ];

    protected $casts = [
        'buttons' => 'array',
        'api_response' => 'array',
        'body_examples' => 'array'
    ];

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'in_appeal' => 'bg-purple-100 text-purple-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFormattedNameAttribute()
    {
        return str_replace('_', ' ', $this->name);
    }

    public function getButtonsCountAttribute()
    {
        return is_array($this->buttons) ? count($this->buttons) : 0;
    }

    public function hasMediaHeader()
    {
        return in_array($this->header_type, ['image', 'video', 'document']);
    }

    public function getHeaderMediaUrlAttribute()
    {
        switch ($this->header_type) {
            case 'image':
                return $this->header_image_url;
            case 'video':
                return $this->header_video_url;
            case 'document':
                return $this->header_document_url;
            default:
                return null;
        }
    }

    /**
     * Default variables that will be available in all templates
     */
    protected function getDefaultVariables(): array
    {
        return [
            'company_logo' => [
                'value' => config('app.company_logo', 'https://example.com/logo.png'),
                'description' => 'URL of the company logo'
            ],
            'company_name' => [
                'value' => config('app.company_name', 'LoopLynks'),
                'description' => 'Name of the company'
            ],
            'company_signature' => [
                'value' => config('app.company_signature', 'Best regards,<br>LoopLynks Team'),
                'description' => 'Company signature block'
            ],
            'current_year' => [
                'value' => date('Y'),
                'description' => 'Current year'
            ]
        ];
    }

    /**
     * Get the compiled content with replaced variables
     */
    public function compile(array $data): array
    {
        // Merge custom data with default variables
        $allVariables = array_merge(
            $this->getDefaultVariableValues(),
            $data
        );

        return [
            'subject' => $this->replaceVariables($this->subject, $allVariables),
            'body_text' => $this->replaceVariables($this->content, $allVariables)
        ];
    }

    /**
     * Get just the values of default variables
     */
    protected function getDefaultVariableValues(): array
    {
        return collect($this->getDefaultVariables())
            ->mapWithKeys(fn($item, $key) => [$key => $item['value']])
            ->toArray();
    }

    /**
     * Replace variables in the text with actual values
     */
    protected function replaceVariables(string $text, array $data): string
    {
        return Str::replace(
            array_map(fn($var) => "{{{$var}}}", array_keys($data)),
            array_values($data),
            $text
        );
    }

    /**
     * Get all available variables with descriptions (custom + default)
     */
    public function getAvailableVariables(): array
    {
        $defaultVars = $this->getDefaultVariables();
        $customVars = collect($this->variables ?? [])
            ->mapWithKeys(fn($item) => [$item['name'] => $item['description']])
            ->toArray();

        return array_merge($defaultVars, $customVars);
    }
}
