<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Controls\Form;

use DOMElement;
use Exception;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Class FormElement
 * @package Panda\Ui\Html\Controls\Form
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
     * @param HTMLDocument      $HTMLDocument The item's parent document
     * @param string            $itemName     The item tagName
     * @param string            $name         The item name attribute
     * @param string            $value        The item value attribute
     * @param string            $id           The item id attribute
     * @param string            $class        The item class attribute
     * @param string|DOMElement $itemValue    The item content value.
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $itemName = '', $name = '', $value = '', $id = '', $class = '', $itemValue = '')
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
