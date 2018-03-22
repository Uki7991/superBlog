<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/16/18
 * Time: 10:54 AM
 */

if (!function_exists('dd')) {
    function dd($var)
    {
        dump($var);
        die;
    }
}
