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
 * HTML Form Element
 *
 * Create HTML form items
 *
 * @version    0.1
 */
class FormElement extends HTMLElement
{
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
    public function __construct(DOMPrototype $HTMLDocument, $itemName = "", $name = "", $value = "", $id = "", $class = "", $itemValue = "")
    {
        // Create HTMLElement
        parent::__construct($HTMLDocument, $itemName, $itemValue, $id, $class);

        // Add extra attributes
        $this->attr("name", $name);
        $this->attr("value", $value);
    }
}

?>