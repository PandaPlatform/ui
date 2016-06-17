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

namespace Panda\Ui\Contracts\Handlers;

use DOMElement;
use Exception;

/**
 * Interface HTMLHandlerInterface
 *
 * @package Panda\Ui\Contracts\Handlers
 *
 * @version 0.1
 */
interface HTMLHandlerInterface extends DOMHandlerInterface
{
    /**
     * Append a class to the DOMElement.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $class   The class name.
     *
     * @return DOMElement
     *
     * @throws Exception
     */
    public function addClass(DOMElement &$element, $class);

    /**
     * Removes a class from the DOMElement.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $class   The class name.
     *
     * @return DOMElement
     *
     * @throws Exception
     */
    public function removeClass(DOMElement &$element, $class);

    /**
     * Check if the DOMElement has a class.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $class   The class name.
     *
     * @return bool True if the element has the class, false otherwise.
     */
    public function hasClass(DOMElement $element, $class);

    /**
     * Set or get a style value.
     * This function will append the style rule in the style attribute.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $name    The style name.
     * @param string     $val     If the value is NULL or FALSE, the value is considered negative and the style will be
     *                            removed from the attribute. If the value is empty string (default, null is not
     *                            included), the function will return the style value. Otherwise, the style will be
     *                            appended to the style attribute and the new attribute will be returned.
     *
     * @return DOMElement|mixed
     */
    public function style(DOMElement &$element, $name, $val = '');

    /**
     * Get or Set inner HTML.
     * Returns the inner html of the element if no content is given.
     * Sets the innerHTML of an element elsewhere.
     *
     * @param DOMElement $element         The DOMElement to handle.
     * @param string     $value           The html value to be set.
     *                                    If empty, it returns the innerHTML of the element.
     * @param bool       $faultTolerant   Indicates whenever innerHTML will try to fix (well format html) the inserted
     *                                    string value.
     * @param bool       $convertEncoding Option to convert the encoding of the value to UTF-8.
     *
     * @return DOMElement|mixed
     */
    public function innerHTML(DOMElement &$element, $value = null, $faultTolerant = true, $convertEncoding = true);

    /**
     * Get the DOMElement outer html.
     *
     * @param DOMElement $element The DOMElement to handle.
     *
     * @return string
     */
    public function outerHTML(DOMElement $element);
}