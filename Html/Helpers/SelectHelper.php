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

use DOMElement;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;

/**
 * Class SelectHelper
 * @package Panda\Ui\Html\Helpers
 */
class SelectHelper
{
    /**
     * Sets the given array as options in select.
     *
     * For example:
     * If we are given an array the keys of the array will be the options values
     * and the key values will be the options titles.
     *
     * @param HTMLFactoryInterface $factory
     * @param DOMElement           $select
     * @param array                $options
     * @param mixed                $checkedValue
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function setOptions(HTMLFactoryInterface $factory, DOMElement $select, $options = [], $checkedValue = null)
    {
        foreach ($options as $value => $title) {
            // Build option
            $option = $factory->buildHtmlElement('option', $title);
            $option->attr('value', $value);

            // Set checked
            if ($checkedValue && $checkedValue == $value) {
                $option->attr('selected', 'selected');
            }

            // Append option to container
            $factory->getHTMLHandler()->append($select, $option);
        }
    }

    /**
     * Sets the given array as groups in select.
     *
     * Get label and options from each group and apply accordingly.
     *
     * @param HTMLFactoryInterface $factory
     * @param DOMElement           $select
     * @param array                $groups
     * @param mixed                $checkedValue
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function setGroups(HTMLFactoryInterface $factory, DOMElement $select, $groups = [], $checkedValue = null)
    {
        foreach ($groups as $data) {
            $label = $data['label'];
            $options = $data['options'];

            // Build group
            $group = $factory->buildHtmlElement('optgroup', '', '', '', [
                'label' => $label,
            ]);

            // Add options to group
            self::setOptions($factory, $group, $options, $checkedValue);

            // Append group to container
            $factory->getHTMLHandler()->append($select, $group);
        }
    }
}
