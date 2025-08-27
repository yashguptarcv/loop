<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* `booking`.`settings` */
        $settings = array(
            array('key' => 'general.settings.default_lead_status', 'value' => '1', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.lead_assigned_user', 'value' => '2', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.default_currency', 'value' => 'USD', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.whatsapp.access_token', 'value' => 'EAANFZAOdPIK0BO6fZBOT7qD5tVx4GGDvKInFmeUaZAIP2GwRh4QgxJGDpPmkZCZAjGsUckBtJP0ehWmUDZCH976jso3TQYkp1ZCq5PUGoABwZBMrzdVuEI6dcP9lvf7BdSd1P8mBTyQAkbAMD6udjMpJMfsodZCWnDcfqWeAygzYpftdwdbzRmBGi1VA6tm22ZCmBmq1Q8MSoZD', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.whatsapp.phone_number', 'value' => '620724541133590', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.whatsapp.business_account_id', 'value' => '3587803424690704', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.editor.tiny_api_key', 'value' => 'g6r56tncmnbo4haibzen0nvnz6bsu6ruxxa328uan6ld24c2', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.google.app_name', 'value' => 'LoopLynks', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.google.client_id', 'value' => '715585719224-uus60a67n1a5nuk02bnpfsshijkf4k68.apps.googleusercontent.com', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.google.client_secret', 'value' => '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', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.google.redirect', 'value' => 'http://127.0.0.1:8001/admin/meetings/google/callback', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.google.access_token', 'value' => 'ya29.a0AS3H6NzkZTGVLHcjV0LQo65cSkNXfrh1ddtg2V4vv3EfcKmxNKrXobR3TCylCT6xdH8Da7S81roBbcxLltN9dehZ0AEU0w1SRJHY4-tZAhqZrDnYogXstbv_HSeqGZUly9c0rcoLpM3Gl6NJxPCi5KzCAddRaUjomY3wJeMq1AaCgYKAW8SARYSFQHGX2MiEjnVmLsDtEWdZUlpPm3SbQ0177', 'created_at' => '2025-08-11 09:53:26', 'updated_at' => '2025-08-12 03:59:06'),
            array('key' => 'general.settings.google.refresh_token', 'value' => '1//0gfoH9Vs5ytxICgYIARAAGBASNwF-L9IrEaOLTpJrYKT9gTFv7_CXUQm1HUEp-Thvyzwo_CemWzf11rChjCNlOKdkLZPYI8HGmaI', 'created_at' => '2025-08-11 09:53:26', 'updated_at' => '2025-08-11 09:53:26'),
            array('key' => 'general.settings.google.expires_in', 'value' => '3599', 'created_at' => '2025-08-11 09:53:26', 'updated_at' => '2025-08-11 09:53:26'),
            array('key' => 'general.settings.google.token_type', 'value' => 'Bearer', 'created_at' => '2025-08-11 09:53:26', 'updated_at' => '2025-08-11 09:53:26'),
            array('key' => 'general.settings.google.timestamp', 'value' => '2025-08-12 04:59:05', 'created_at' => '2025-08-11 09:53:26', 'updated_at' => '2025-08-12 03:59:06'),
            array('key' => 'general.settings.timezone', 'value' => 'UTC', 'created_at' => '2025-08-11 09:53:26', 'updated_at' => '2025-08-11 09:53:26'),
            array('key' => 'general.settings.store_name', 'value' => 'LoopLynks', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.default_meeting_gap', 'value' => '10', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.default_meeting_color', 'value' => 'blue', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.default_application_product', 'value' => '1', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.settings.default_admin_pagination_per_page', 'value' => '10', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.orders.order_number_prefix', 'value' => 'LPL', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.orders.order_number_suffix', 'value' => '', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.tax.tax_shipping', 'value' => '', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.tax.shipping_tax_class', 'value' => '', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.tax.use_shipping_address_for_tax', 'value' => 'N', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.checkout.is_required_shipping_address', 'value' => 'N', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.checkout.default_order_status', 'value' => 'O', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.checkout.default_complete_order_status', 'value' => 'J', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.checkout.default_cancelled_order_status', 'value' => 'N', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.checkout.default_failed_order_status', 'value' => 'L', 'created_at' => NULL, 'updated_at' => NULL),

            array('key' => 'general.mail.driver', 'value' => 'smtp', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.host', 'value' => 'smtp.gmail.com', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.port', 'value' => '465', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.username', 'value' => 'rishabh.chaudhary@rcvtechnologies.com', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.password', 'value' => 'pifz zfaq pgjy rlco', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.encryption', 'value' => 'ssl', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.from_address', 'value' => 'rishabh.chaudhary@rcvtechnologies.com', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.from_name', 'value' => 'Socail Ant', 'created_at' => NULL, 'updated_at' => NULL),
            array('key' => 'general.mail.cc_mails', 'value' => '', 'created_at' => NULL, 'updated_at' => NULL)
        );
        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert($value);
        }
    }
}
