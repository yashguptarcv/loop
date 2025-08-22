<?php

use Modules\Filemanager\Services\FileService;

if(!function_exists('fn_get_image')) {
    function fn_get_image($object_type, $object_id = 0) {
        try {
            $fileservice    =   new FileService();
            return $fileservice->getFile($object_type, $object_id);
        } catch(Exception $e) {            
            return false;
        }
    }
}

if(!function_exists('fn_get_upload_driver')) {
    function fn_get_upload_driver() {
        return [
            'public', 
        ];
    }
}