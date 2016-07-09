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

use Panda\Ui\Contracts\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\HTMLElement;

/**
 * Class NavigationUiHelper
 *
 * @package Panda\Ui\Helpers
 *
 * @version 0.1
 */
class NavigationUiHelper
{
    const DISPLAY_NONE = 'none';
    const DISPLAY_ALL = 'all';
    const DISPLAY_TOGGLE = 'toggle';

    /**
     * Adds static navigation handler
     *
     * @param HTMLHandlerInterface $HTMLHandler       The HTMLHandler to set attributes.
     * @param HTMLElement          $HTMLElement       The element to receive the navigation handler
     * @param string               $ref               The target's id to perform the action
     * @param string               $targetContainerId The container's id of the group in which the target resides
     * @param string               $targetGroupId     The group of the items to handle together when performing the
     *                                                action to the target. References the data-targetgroupid value
     * @param string               $navGroup          The group of navigation items, among which the handler element
     *                                                will be selected
     * @param string               $display           Defines the type of action for the rest items of the group.
     *                                                Accepted values:
     *                                                - 'none' : hides all other items
     *                                                - 'all' : shows all other items
     *                                                - 'toggle' : toggles the appearance of the handler item
     */
    public static function staticNav(HTMLHandlerInterface $HTMLHandler, HTMLElement $HTMLElement, $ref, $targetContainerId, $targetGroupId, $navGroup, $display = self::DISPLAY_NONE)
    {
        $staticNav = [];
        $staticNav['ref'] = $ref;
        $staticNav['targetcontainerid'] = $targetContainerId;
        $staticNav['targetgroupid'] = $targetGroupId;
        $staticNav['navgroup'] = $navGroup;
        $staticNav['display'] = $display;

        $HTMLHandler->data($HTMLElement, 'static-nav', $staticNav);
    }

    /**
     * Adds static navigation group selector (staticNav's targetGroupId)
     *
     * @param HTMLHandlerInterface $HTMLHandler   The HTMLHandler to set attributes.
     * @param HTMLElement          $HTMLElement   The element to receive the selector
     * @param string               $targetGroupId The group id
     */
    public static function setTargetGroupId(HTMLHandlerInterface $HTMLHandler, HTMLElement $HTMLElement, $targetGroupId)
    {
        $HTMLHandler->data($HTMLElement, 'data-targetgroupid', $targetGroupId);
    }
}
