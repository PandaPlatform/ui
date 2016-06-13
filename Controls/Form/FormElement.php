<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Panda\Ui\Controls\Form;

use Panda\Ui\DOMPrototype;
use Panda\Ui\Html\HTMLElement;

/**
 * Class FormElement
 *
 * @package Panda\Ui\Controls\Form
 * @version 0.1
 */
class FormElement extends HTMLElement
{
    /**
     * All the accepted element types.
     * Extend this property to validate the element type.
     *
     * @var array
     */
    protected $types;

    /**
     * Create a new form item.
     *
     * @param DOMPrototype $HTMLDocument The DOMDocument to create the element
     * @param string       $itemName     The item's tagName
     * @param string       $name         The item's name attribute
     * @param string       $value        The item's value attribute
     * @param string       $id           The item's id attribute
     * @param string       $class        The item's class attribute
     * @param string       $itemValue    The item's content value.
     *                                   It can be string or DOMElement.
     */
    public function __construct(DOMPrototype $HTMLDocument, $itemName = '', $name = '', $value = '', $id = '', $class = '', $itemValue = '')
    {
        // Create HTMLElement
        parent::__construct($HTMLDocument, $itemName, $itemValue, $id, $class);

        // Add extra attributes
        $this->attr('name', $name);
        $this->attr('value', $value);
    }

    /**
     * Checks if the given element type is valid for HTML4 and HTML5.
     *
     * @param string $type The element's type to check.
     *
     * @return bool True if the type is valid, false otherwise.
     */
    protected function checkType($type)
    {
        // If no types to check are defined return true
        if (empty($this->types)) {
            return true;
        }

        // Check input type
        $expression = implode('|', $this->types);
        $valid = preg_match('/^(' . $expression . ')$/', $type);

        return $valid === 1;
    }
}

