<?php

namespace Front\Model\Common;

class Url
{
    /**
     * 
     * @param string $string
     * @return string
     */
    public static function clear($string) {
        $string = mb_strtolower($string, 'UTF-8');
        $string = str_replace(
                array('ę','ó','ą','ś','ł','ż','ź','ć','ń', ' ', ','),
                array('e','o','a','s','l','z','z','c','n', '_', ''),
                $string);
        return $string;
    }
}

