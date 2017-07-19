<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Helpers;

/**
 * Class HTMLHelper
 * @package Panda\Ui\Html\Helpers
 */
class HTMLHelper
{
    /**
     * @var array
     */
    private static $validHTMLTags = [
        'div',
        'p',
    ];

    /**
     * Check if the given xml tag is a valid html tag.
     *
     * @param string $tag The html tag to be checked.
     *
     * @return bool
     */
    public static function validHtmlTag($tag)
    {
        // Check if the tag is valid html tag
        return in_array($tag, static::$validHTMLTags);
    }
}
