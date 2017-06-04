<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib;

use Phalcon\Tag as BaseTag;

/**
 * Extended tag service
 */
class Tag extends BaseTag
{

    /**
     * Translate helper
     * @static
     * @param  string $translateKey
     * @param  array $placeholders - default null
     * @return string
     */
    public static function _($translateKey, $placeholders = null)
    {
        return self::getDI()->get('translate')->t($translateKey, $placeholders);
    }

    /**
     * Truncates string to given length
     * @static
     * @param string $str
     * @param int $len
     */
    public static function cutstr($str, $len)
    {
        $str = strip_tags($str);
        if (mb_strlen($str) <= $len) {
            return $str;
        }
        return mb_substr($str, 0, $len) . '&hellip;';
    }
}
