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

namespace Panda\Ui\Html;

use Exception;
use Panda\Ui\Contracts\Handlers\HTMLHandlerInterface;
use Panda\Ui\DOMItem;

/**
 * HTMLElement Class
 * Extends the DOMItem with HTML-specific functionality
 *
 * @package Panda\Ui\Html
 *
 * @version 0.1
 */
class HTMLElement extends DOMItem
{
    /**
     * Create a new HTMLObject.
     *
     * @param HTMLDocument         $HTMLDocument
     * @param string               $name  The elemenet name.
     * @param string|HTMLElement   $value The element value.
     * @param string               $id    The element id attribute value.
     * @param string               $class The element class attribute value.
     *
     */
    public function __construct(HTMLDocument $HTMLDocument, $name, $value = '', $id = '', $class = '')
    {
        // Create DOMItem
        parent::__construct($HTMLDocument, $name, $value);

        // Add extra attributes
        $this->attr('id', $id);
        $this->addClass($class);
    }

    /**
     * Append a class to the HTMLObject.
     *
     * @param string $class The class name.
     *
     * @return $this
     *
     * @throws Exception
     */
    public function addClass($class)
    {
        return $this->getHTMLHandler()->addClass($this, $class);
    }

    /**
     * Removes a class from a given DOMElement.
     *
     * @param string $class The class name.
     *
     * @return $this
     *
     * @throws Exception
     */
    public function removeClass($class)
    {
        return $this->getHTMLHandler()->removeClass($this, $class);
    }


    /**
     * Check if the given DOMElement has a given class.
     *
     * @param string $class The class name.
     *
     * @return bool True if the element has the class, false otherwise.
     */
    public function hasClass($class)
    {
        return $this->getHTMLHandler()->hasClass($this, $class);
    }

    /**
     * Set or get a style value.
     * This function will append the style rule in the style attribute.
     *
     * @param string $name The style name.
     * @param string $val  If the value is NULL or FALSE, the value is considered negative and the style will be
     *                     removed from the attribute. If the value is empty string (default, null is not
     *                     included), the function will return the style value. Otherwise, the style will be
     *                     appended to the style attribute and the new attribute will be returned.
     *
     * @return $this|mixed
     */
    public function style($name, $val = '')
    {
        return $this->getHTMLHandler()->style($this, $name, $val);
    }

    /**
     * Get or Set inner HTML.
     * Returns the inner html of the element if no content is given.
     * Sets the innerHTML of an element elsewhere.
     *
     * @param string $value           The html value to be set.
     *                                If empty, it returns the innerHTML of the element.
     * @param bool   $faultTolerant   Indicates whenever innerHTML will try to fix (well format html) the inserted
     *                                string value.
     * @param bool   $convertEncoding Option to convert the encoding of the value to UTF-8.
     *
     * @return mixed|$this
     */
    public function innerHTML($value = null, $faultTolerant = true, $convertEncoding = true)
    {
        return $this->getHTMLHandler()->innerHTML($this, $value, $faultTolerant, $convertEncoding);
    }

    /**
     * Get the DOMElement outer html.
     *
     * @return string
     */
    public function outerHTML()
    {
        return $this->getHTMLHandler()->outerHTML($this);
    }

    /**
     * @return HTMLDocument
     */
    public function getHTMLDocument()
    {
        return $this->getDOMDocument();
    }

    /**
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->getDOMHandler();
    }
}

