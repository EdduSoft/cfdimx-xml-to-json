<?php

namespace Lib;

class Helper {

    /**
     * Get attribute from node element
     *
     * @param [type] $elem
     * @param [type] $attr
     * @return String
     */
    public static function getAttr($attr, $elem)
    {
        try {
            return $elem->getAttribute($attr);
        } catch (\Exception $e) {
            return null;
        }
    }

}