<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Helpers;

use DOMNode;
use Panda\Ui\Contracts\Handlers\HTMLHandlerInterface;

/**
 * Class TooltipHelper
 *
 * @package Panda\Ui\Helpers
 *
 * @version 0.1
 */
class TooltipHelper
{
    /**
     * Set tooltip handler attribute
     *
     * @param HTMLHandlerInterface $HTMLHandler
     * @param DOMNode              $HTMLElement
     * @param string               $content
     * @param int                  $delay
     */
    public static function set(HTMLHandlerInterface $HTMLHandler, DOMNode $HTMLElement, $content, $delay = 0)
    {
        // Set tooltip attribute array
        $tooltip = [];
        $tooltip['content'] = $content;
        $tooltip['delay'] = $delay;

        $HTMLHandler->data($HTMLElement, 'ui-tooltip', $tooltip);
    }
}
