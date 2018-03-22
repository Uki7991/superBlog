<?php
/**
 * Created by PhpStorm.
 * User: kubanov
 * Date: 3/22/18
 * Time: 3:26 PM
 */

namespace AppBundle\Utils;


class Helper
{

    static public function slugify($text)
    {
        $slug = preg_replace('/\W+/', '-', $text);

        $slug = strtolower(trim($slug, '-'));

        return $slug;
    }
}