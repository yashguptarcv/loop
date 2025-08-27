<?php

namespace Modules\EmailNotification\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'content',
        'locale',
        'status'
    ];

    protected $table = 'email_templates';

    protected $casts = [
        'status' => 'boolean'
    ];

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
            'content' => $this->replaceVariables($this->content, $allVariables)
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
