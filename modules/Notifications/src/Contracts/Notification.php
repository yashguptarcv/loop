<?php

namespace Modules\Notifications\Contracts;

interface Notification
{
    // Get the notification event code
    public function getEventCode(): string;

    // Get the variables for template replacement
    public function getVariables(): array;

    // Get the template identifier
    public function getTemplateIdentifier(): array;

    // Convert notification to array
    public function toArray(): array;
}
