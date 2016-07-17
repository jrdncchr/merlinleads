<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('findObjInArray')) {
    function _findObjInArray($array, $key)
    {
        foreach ($array as $obj) {
            if ($key == $obj->k) {
                return $obj->v;
            }
        }
        return null;
    }
}
if (!function_exists('transformArrayToKeyValue')) {
    function transformArrayToKeyValue($array)
    {
        $new = array();
        foreach ($array as $obj) {
            $new[$obj->k] = $obj;
        }
        return $new;
    }
}
