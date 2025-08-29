<?php

namespace Modules\Customers\Helper;

use Modules\Customers\Models\Address;

class AddressHelper
{
    /**
     * Format address for different view types
     */
    public static function format(array|Address $address, string $format = 'default'): string
    {
        if ($address instanceof Address) {
            $address = $address->toArray();
        }

        // Ensure we have an array with expected keys
        $address = array_merge([
            'name' => '',
            'company' => '',
            'address_1' => '',
            'address_2' => '',
            'city' => '',
            'state' => '',
            'postcode' => '',
            'country' => '',
            'email' => '',
            'phone' => '',
        ], $address);

        return match($format) {
            'inline' => self::formatInline($address),
            'multiline' => self::formatMultiline($address),
            'compact' => self::formatCompact($address),
            'html' => self::formatHtml($address),
            'shipping_label' => self::formatShippingLabel($address),
            'billing' => self::formatBilling($address),
            'default' => self::formatDefault($address),
        };
    }

    /**
     * Default format (multiline without name)
     */
    private static function formatDefault(array $address): string
    {
        $lines = [];

        if (!empty($address['address_1'])) {
            $lines[] = $address['address_1'];
        }

        if (!empty($address['address_2'])) {
            $lines[] = $address['address_2'];
        }

        $cityState = array_filter([
            $address['city'],
            fn_get_state_name($address['state']),
            $address['postcode']
        ]);

        if (!empty($cityState)) {
            $lines[] = implode(', ', $cityState);
        }

        if (!empty($address['country'])) {
            $lines[] = fn_get_country_name($address['country']);
        }

        return implode("\n", $lines);
    }

    /**
     * Single line format
     */
    private static function formatInline(array $address): string
    {
        $parts = [];

        if (!empty($address['address_1'])) {
            $parts[] = $address['address_1'];
        }

        if (!empty($address['address_2'])) {
            $parts[] = $address['address_2'];
        }

        $cityState = array_filter([
            $address['city'],
            fn_get_state_name($address['state']),
            $address['postcode']
        ]);

        if (!empty($cityState)) {
            $parts[] = implode(', ', $cityState);
        }

        if (!empty($address['country'])) {
            $parts[] = fn_get_country_name($address['country']);
        }

        return implode(', ', $parts);
    }

    /**
     * Multiline format with name and company
     */
    private static function formatMultiline(array $address): string
    {
        $lines = [];

        // Name
        if (!empty($address['name'])) {
            $lines[] = $address['name'];
        }

        // Company
        if (!empty($address['company'])) {
            $lines[] = $address['company'];
        }

        // Address lines
        if (!empty($address['address_1'])) {
            $lines[] = $address['address_1'];
        }

        if (!empty($address['address_2'])) {
            $lines[] = $address['address_2'];
        }

        // City, State, Postcode
        $cityState = array_filter([
            $address['city'],
            fn_get_state_name($address['state']),
            $address['postcode']
        ]);

        if (!empty($cityState)) {
            $lines[] = implode(', ', $cityState);
        }

        // Country
        if (!empty($address['country'])) {
            $lines[] = fn_get_country_name($address['country']);
        }

        // Contact info
        $contact = array_filter([
            $address['email'],
            $address['phone']
        ]);

        if (!empty($contact)) {
            $lines[] = implode(' | ', $contact);
        }

        return implode("\n", $lines);
    }

    /**
     * Compact format for tight spaces
     */
    private static function formatCompact(array $address): string
    {
        $parts = [];

        if (!empty($address['city'])) {
            $parts[] = $address['city'];
        }

        if (!empty($address['state'])) {
            $parts[] = fn_get_state_name($address['state']);
        }

        if (!empty($address['country'])) {
            $parts[] = fn_get_country_name($address['country']);
        }

        return implode(', ', $parts);
    }

    /**
     * HTML format with line breaks
     */
    private static function formatHtml(array $address): string
    {
        $lines = [];

        // Name
        if (!empty($address['name'])) {
            $lines[] = '<strong>' . $address['name']. '</strong>';
        }

        // Company
        if (!empty($address['company'])) {
            $lines[] = '<em>' . $address['company'] . '</em>';
        }

        // Address lines
        if (!empty($address['address_1'])) {
            $lines[] = $address['address_1'];
        }

        if (!empty($address['address_2'])) {
            $lines[] = $address['address_2'];
        }

        // City, State, Postcode
        $cityState = array_filter([
            $address['city'],
            fn_get_state_name($address['state']),
            $address['postcode']
        ]);

        if (!empty($cityState)) {
            $lines[] = implode(', ', $cityState);
        }

        // Country
        if (!empty($address['country'])) {
            $lines[] = fn_get_country_name($address['country']);
        }

        // Contact info
        $contact = [];
        if (!empty($address['email'])) {
            $contact[] = '<a href="mailto:' . $address['email'] . '">' . $address['email'] . '</a>';
        }
        if (!empty($address['phone'])) {
            $contact[] = '<a href="tel:' . $address['phone'] . '">' . $address['phone'] . '</a>';
        }

        if (!empty($contact)) {
            $lines[] = implode(' | ', $contact);
        }

        return implode('<br>', $lines);
    }

    /**
     * Shipping label format
     */
    private static function formatShippingLabel(array $address): string
    {
        $lines = [];

        // Name
        if (!empty($address['name'])) {
            $lines[] = strtoupper($address['name']);
        }

        // Company
        if (!empty($address['company'])) {
            $lines[] = strtoupper($address['company']);
        }

        // Address lines
        if (!empty($address['address_1'])) {
            $lines[] = $address['address_1'];
        }

        if (!empty($address['address_2'])) {
            $lines[] = $address['address_2'];
        }

        // City, State, Postcode
        $cityState = array_filter([
            $address['city'],
            fn_get_state_name($address['state']),
            $address['postcode']
        ]);

        if (!empty($cityState)) {
            $lines[] = implode(' ', $cityState);
        }

        // Country
        if (!empty($address['country'])) {
            $lines[] = strtoupper(fn_get_country_name($address['country']));
        }

        return implode("\n", $lines);
    }

    /**
     * Billing address format with emphasis on contact info
     */
    private static function formatBilling(array $address): string
    {
        $lines = [];

        // Name
        if (!empty($address['name'])) {
            $lines[] = $address['name'];
        }

        // Company
        if (!empty($address['company'])) {
            $lines[] = $address['company'];
        }

        // Address lines
        if (!empty($address['address_1'])) {
            $lines[] = $address['address_1'];
        }

        if (!empty($address['address_2'])) {
            $lines[] = $address['address_2'];
        }

        // City, State, Postcode
        $cityState = array_filter([
            $address['city'],
            fn_get_state_name($address['state']),
            $address['postcode']
        ]);

        if (!empty($cityState)) {
            $lines[] = implode(', ', $cityState);
        }

        // Country
        if (!empty($address['country'])) {
            $lines[] = fn_get_country_name($address['country']);
        }

        // Contact info
        if (!empty($address['email'])) {
            $lines[] = 'Email: ' . $address['email'];
        }

        if (!empty($address['phone'])) {
            $lines[] = 'Phone: ' . $address['phone'];
        }

        return implode("\n", $lines);
    }

    /**
     * Get country name from code
     */
    public static function getCountryName(string $countryCode): string
    {
        $countries = [
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'DE' => 'Germany',
            'FR' => 'France',
            // Add more countries as needed
        ];

        return $countries[$countryCode] ?? $countryCode;
    }

    /**
     * Check if address is complete
     */
    public static function isValid(array|Address $address): bool
    {
        if ($address instanceof Address) {
            $address = $address->toArray();
        }

        $required = ['address_1', 'city', 'postcode', 'country'];
        
        foreach ($required as $field) {
            if (empty($address[$field])) {
                return false;
            }
        }

        return true;
    }
}