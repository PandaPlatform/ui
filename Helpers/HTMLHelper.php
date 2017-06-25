<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Helpers;

/**
 * Document Object Model (DOM/HTML) Helper file
 * This file is a helper containing tool functions
 * for html-specific functionality.
 *
 * @package Panda\Ui\Helpers
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
     * @return bool True if valid, false otherwise.
     */
    public static function validHtmlTag($tag)
    {
        // Check if the tag is valid html tag
        return in_array($tag, static::$validHTMLTags);
    }
}
