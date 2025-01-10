<?php

namespace App\Helpers;

class CustomHelpers
{
    public static function isContentValid($content)
    {
        if(!$content || trim($content) == '' || $content == 'null' || $content == 'undefined' || $content == 'NaN'){
            return false;
        }
        return true;
    }
}