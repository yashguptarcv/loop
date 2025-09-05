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
            array('key' => 'general.tax.tax_shipping','value' => '','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.tax.shipping_tax_class','value' => '','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.tax.use_shipping_address_for_tax','value' => 'N','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.checkout.is_required_shipping_address','value' => 'N','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.checkout.default_order_status','value' => 'Failed','created_at' => NULL,'updated_at' => '2025-08-21 04:35:26'),
            array('key' => 'general.checkout.default_complete_order_status','value' => NULL,'created_at' => NULL,'updated_at' => '2025-08-21 04:35:26'),
            array('key' => 'general.checkout.default_cancelled_order_status','value' => 'N','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.checkout.default_failed_order_status','value' => 'L','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.mail.driver','value' => NULL,'created_at' => NULL,'updated_at' => '2025-08-22 04:44:40'),
            array('key' => 'general.mail.host','value' => 'sandbox.smtp.mailtrap.io','created_at' => NULL,'updated_at' => '2025-08-25 04:14:21'),
            array('key' => 'general.mail.port','value' => '2525','created_at' => NULL,'updated_at' => '2025-08-25 04:14:21'),
            array('key' => 'general.mail.username','value' => '58c8fb44b6a7b4','created_at' => NULL,'updated_at' => '2025-08-25 04:14:21'),
            array('key' => 'general.mail.password','value' => '8c536ecdef3816','created_at' => NULL,'updated_at' => '2025-08-25 04:14:21'),
            array('key' => 'general.mail.encryption','value' => 'tsl','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.mail.from_address','value' => 'yash121999@gmail.com','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.mail.from_name','value' => 'LoopLynks','created_at' => NULL,'updated_at' => '2025-08-21 05:51:57'),
            array('key' => 'general.mail.cc_mails','value' => NULL,'created_at' => NULL,'updated_at' => '2025-08-21 04:35:32'),
            array('key' => 'general.lead.roles','value' => 'Administrator','created_at' => '2025-08-21 08:05:57','updated_at' => '2025-08-21 08:06:10'),
            array('key' => 'general.mail.mail_from','value' => 'yash121999@gmail.com','created_at' => '2025-08-22 04:44:40','updated_at' => '2025-08-25 04:14:21'),
            array('key' => 'general.mail.mail_from_name','value' => 'LoopLynks','created_at' => '2025-08-22 04:44:40','updated_at' => '2025-08-25 04:14:21'),
            array('key' => 'general.mail.cc','value' => NULL,'created_at' => '2025-08-22 04:44:40','updated_at' => '2025-08-22 04:44:40'),
            array('key' => 'general.timezone','value' => 'Asia/Kolkata','created_at' => '2025-08-22 06:27:08','updated_at' => '2025-08-22 06:27:08'),
            array('key' => 'general.timestamp','value' => 'on','created_at' => '2025-08-22 06:27:08','updated_at' => '2025-08-22 06:27:08'),
            array('key' => 'general.currency','value' => 'USD','created_at' => '2025-08-22 06:27:08','updated_at' => '2025-08-22 06:27:08'),
            array('key' => 'general.tax','value' => '1','created_at' => '2025-08-22 06:27:08','updated_at' => '2025-08-22 06:27:08'),
            array('key' => 'general.order.prefix','value' => 'LL','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.order.suffix','value' => NULL,'created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.order.length','value' => '8','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.order.auto_generate','value' => 'N','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.order.create','value' => 'O','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-25 08:51:35'),
            array('key' => 'general.order.processing','value' => 'H','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-25 08:51:35'),
            array('key' => 'general.order.complete','value' => 'Z','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-25 08:51:35'),
            array('key' => 'general.order.cancelled','value' => 'C','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-25 08:51:35'),
            array('key' => 'general.order.failed','value' => 'F','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-25 08:51:35'),
            array('key' => 'general.order.refunded','value' => 'R','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-25 08:51:35'),
            array('key' => 'general.checkout.order_expire','value' => '30','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.checkout.per_page','value' => '20','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.checkout.included','value' => 'N','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.checkout.show_sku','value' => 'N','created_at' => '2025-08-22 06:29:15','updated_at' => '2025-08-22 06:29:15'),
            array('key' => 'general.editor.api_key','value' => 'g6r56tncmnbo4haibzen0nvnz6bsu6ruxxa328uan6ld24c2','created_at' => '2025-08-22 06:29:36','updated_at' => '2025-08-22 06:29:36'),
            array('key' => 'general.lead.product','value' => '1','created_at' => '2025-08-22 06:29:44','updated_at' => '2025-08-27 05:07:08'),
            array('key' => 'general.lead.user_group','value' => '1','created_at' => '2025-08-22 06:29:44','updated_at' => '2025-08-22 06:29:44'),
            array('key' => 'general.lead.status','value' => '1','created_at' => '2025-08-22 06:29:44','updated_at' => '2025-08-22 06:29:44'),
            array('key' => 'general.image_driver','value' => 'public','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'general.company.name','value' => 'LoopLynks','created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:54:57'),
            array('key' => 'general.company.mail','value' => 'support@looplynks.com','created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:55:10'),
            array('key' => 'general.company.address_street','value' => NULL,'created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:46:04'),
            array('key' => 'general.company.address_city','value' => NULL,'created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:46:04'),
            array('key' => 'general.company.address_state','value' => NULL,'created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:46:04'),
            array('key' => 'general.company.address_postal','value' => NULL,'created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:46:04'),
            array('key' => 'general.company.country','value' => 'AF','created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 07:46:04'),
            array('key' => 'general.company.signature','value' => '','created_at' => '2025-08-22 07:46:04','updated_at' => '2025-08-22 08:45:58'),
            array('key' => 'general.google.app_name','value' => 'LoopLynks','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-25 04:20:51'),
            array('key' => 'general.google.client_id','value' => '654158415415','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-25 04:20:51'),
            array('key' => 'general.google.client_secret','value' => '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','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-25 04:20:51'),
            array('key' => 'general.google.redirect_url','value' => 'http://10.10.1.101:8001/admin/meetings/google/callback','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-25 04:20:51'),
            array('key' => 'general.whatsapp.access_token','value' => 'EAANFZAOdPIK0BO6fZBOT7qD5tVx4GGDvKInFmeUaZAIP2GwRh4QgxJGDpPmkZCZAjGsUckBtJP0ehWmUDZCH976jso3TQYkp1ZCq5PUGoABwZBMrzdVuEI6dcP9lvf7BdSd1P8mBTyQAkbAMD6udjMpJMfsodZCWnDcfqWeAygzYpftdwdbzRmBGi1VA6tm22ZCmBmq1Q8MSoZD','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-22 08:01:35'),
            array('key' => 'general.whatsapp.phone_number','value' => '9874561235','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-22 08:01:35'),
            array('key' => 'general.whatsapp.business_account_id','value' => '3587803424690704','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-22 08:01:35'),
            array('key' => 'general.google.meeting_gap','value' => '20','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-22 08:01:35'),
            array('key' => 'general.google.meeting_color','value' => 'primary','created_at' => '2025-08-22 08:01:35','updated_at' => '2025-08-22 08:01:35'),
            array('key' => 'general.editor.type','value' => 'tinymce','created_at' => '2025-08-26 08:28:26','updated_at' => '2025-08-26 08:29:31'),
            array('key' => 'general.pass','value' => '2','created_at' => '2025-08-26 13:28:02','updated_at' => '2025-08-26 13:28:02')
        );

        
        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert($value);
        }

        $pages = array(
            array('slug' => '/','title' => 'Home','meta_title' => 'homepage','meta_description' => 'homepage','meta_keywords' => 'homepage','meta_og_image' => NULL,'view' => 'shop::shop.index','content' => 'sa dasd','status' => 'active','created_at' => '2025-08-26 11:11:19','updated_at' => '2025-08-26 11:11:19'),
            array('slug' => 'about','title' => 'About','meta_title' => 'about','meta_description' => 'about','meta_keywords' => 'about','meta_og_image' => NULL,'view' => 'shop::shop.about','content' => 'sa dasdasdasd','status' => 'active','created_at' => '2025-08-26 11:11:43','updated_at' => '2025-08-26 11:11:43')
        );

        foreach ($pages as $key => $value) {
            DB::table('pages')->updateOrInsert($value);
        }

        $products = array(
            array('name' => 'Pass','slug' => 'pass','description' => '<p>this is the pass form</p>','price' => '200.00','sale_price' => '100.00','sku' => NULL,'tax_id' => NULL,'image' => NULL,'track_stock' => 'N','stock_quantity' => '0','stock_status' => 'in_stock','status' => 'hidden','is_featured' => '0','created_at' => '2025-08-14 09:53:18','updated_at' => '2025-08-20 14:10:30'),
            array('name' => 'Nomination Form','slug' => 'nomination-form','description' => '<p>this is application form</p>','price' => '99.00','sale_price' => NULL,'sku' => NULL,'tax_id' => '1','image' => NULL,'track_stock' => 'N','stock_quantity' => '0','stock_status' => 'in_stock','status' => 'hidden','is_featured' => '0','created_at' => '2025-08-21 07:26:41','updated_at' => '2025-08-29 13:17:24'),
        );

        foreach ($products as $key => $value) {
            DB::table('products')->updateOrInsert($value);
        }

        $notification_events = array(
            array('event_code' => 'order_created','event_name' => 'Order Creation','event_description' => 'Order Create notification','created_at' => NULL,'updated_at' => NULL),
            array('event_code' => 'application_send','event_name' => 'Application Send','event_description' => 'Application send','created_at' => NULL,'updated_at' => NULL),
            array('event_code' => 'create_user_account','event_name' => 'User Account Create','event_description' => 'Send mail when user created.','created_at' => NULL,'updated_at' => NULL),
            array('event_code' => 'update_user_account','event_name' => 'User Account Update','event_description' => 'Send mail when user update.','created_at' => NULL,'updated_at' => NULL)
        );

        foreach ($notification_events as $key => $value) {
            DB::table('notification_events')->updateOrInsert($value);
        }

    }
}
