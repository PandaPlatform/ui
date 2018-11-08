<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html;

use DOMElement;
use DOMNodeList;
use Exception;
use InvalidArgumentException;
use Panda\Ui\Dom\DOMItem;
use Panda\Ui\Dom\DOMPrototype;
use Panda\Ui\Dom\Handlers\DOMHandlerInterface;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\Helpers\FormHelper;
use Panda\Ui\Html\Helpers\SelectHelper;

/**
 * Class HTMLElement
 * @package Panda\Ui\Html
 */
class HTMLElement extends DOMItem
{
    /**
     * Create a new HTMLObject.
     *
     * @param HTMLDocument       $HTMLDocument The element owner HTMLDocument.
     * @param string             $name         The element name.
     * @param string|HTMLElement $value        The element value.
     * @param string             $id           The element id attribute value.
     * @param string             $class        The element class attribute value.
     * @param array              $attributes
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $name, $value = '', $id = '', $class = '', $attributes = [])
    {
        // Create DOMItem
        parent::__construct($HTMLDocument, $name, $value, '', $attributes);

        // Add extra attributes
        $this->attr('id', $id);
        $this->addClass($class);
    }

    /**
     * Inserts a data-[name] attribute.
     * It supports single value or an array of values.
     *
     * @param string $name  The data name of the attribute (data-[name])
     * @param mixed  $value The data value.
     *                      It can be a single value or an array of values.
     *
     * @return bool|string TRUE or the new value on success, FALSE on failure.
     */
    public function data($name, $value = [])
    {
        return $this->getHTMLHandler()->data($this, $name, $value);
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
     * @param string $class
     *
     * @return bool
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
     * Selects nodes in the owner html document that match a given css selector.
     *
     * @param string $selector The css selector to search for in the html document.
     *                         It does not support pseudo-* for the moment and only supports simple equality
     *                         attribute-wise. Can hold multiple selectors separated with comma.
     * @param mixed  $context  Can either be a DOMElement as the context of the search, or a css selector.
     *                         If the selector results in multiple DOMNodes, then the first is selected as the context.
     *                         It is NULL by default.
     *
     * @return DOMNodeList|false
     * @throws InvalidArgumentException
     */
    public function select($selector, $context = null)
    {
        // Set context to the current element if empty
        $context = $context ?: $this;

        return $this->getHTMLDocument()->selectElement($selector, $context);
    }

    /**
     * Render the current HTMLElement with a given set of parameters.
     * Parameters can contain attributes or element-specific data based
     * on the tag name.
     * For more details, read our documentation.
     *
     * @param array $parameters
     * @param mixed $context
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     * @throws \DOMException
     */
    public function render($parameters = [], $context = null)
    {
        foreach ($parameters as $selector => $data) {
            // Render all elements that match the given selector
            $elements = $this->select($selector, $context);
            foreach ($elements as $element) {
                $this->renderElement($element, $data);
            }
        }

        return $this;
    }

    /**
     * @param DOMElement $element
     * @param array      $data
     *
     * @return $this
     * @throws InvalidArgumentException
     * @throws \DOMException
     * @throws Exception
     */
    protected function renderElement(DOMElement $element, $data = [])
    {
        // Check for actions
        $actions = $data['actions'];

        // Check for "delete" action
        if (isset($actions['delete']) && $actions['delete']) {
            $this->getHTMLHandler()->remove($element);

            return $this;
        }

        // Add/Append all attributes
        foreach ($data['attributes'] as $name => $value) {
            // Evaluate given value using scss syntax (replace & with existing value, for class attributes only)
            $existingValue = $this->getHTMLHandler()->attr($element, $name);
            $value = is_string($value) && $name == 'class' ? str_replace('&', $existingValue, $value) : $value;

            // Set new value
            $this->getHTMLHandler()->attr($element, $name, $value);
        }

        // Add/Append all data attributes
        foreach ($data['data'] as $name => $value) {
            // Evaluate given value using scss syntax (replace & with existing value)
            $existingValue = $this->getHTMLHandler()->data($element, $name);
            $value = $name != 'async-get' ? str_replace('&', $existingValue, $value) : $value;

            // Set new value
            $this->getHTMLHandler()->data($element, $name, $value);
        }

        // Check for node value
        $nodeValue = $data['nodeValue'];
        if (!is_null($nodeValue)) {
            $this->getHTMLHandler()->nodeValue($element, $nodeValue);
        }

        // Check for inner html
        $innerHTML = $data['innerHTML'];
        if (!is_null($innerHTML)) {
            $this->getHTMLHandler()->innerHTML($element, $innerHTML);
        }

        // Append children
        $appendElements = $actions['append'] ?: [];
        $appendElements = is_array($appendElements) ? $appendElements : [$appendElements];
        foreach ($appendElements as $appendElement) {
            $this->getHTMLHandler()->append($element, $appendElement);
        }

        // Prepend children
        $prependElements = $actions['prepend'] ?: [];
        $prependElements = is_array($prependElements) ? $prependElements : [$prependElements];
        foreach ($prependElements as $prependElement) {
            $this->getHTMLHandler()->prepend($element, $prependElement);
        }

        // Render tag-specific parameters
        $this->renderSelect($element, $data['select']);
        $this->renderForm($element, $data['form']);

        return $this;
    }

    /**
     * @param DOMElement $select
     * @param array      $data
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    private function renderSelect($select, $data = [])
    {
        // Check for tag name
        if ($select->tagName != 'select') {
            return $this;
        }

        // Set select groups
        SelectHelper::setGroups($this->getHTMLDocument()->getHTMLFactory(), $select, $data['groups'], $data['checked_value']);

        // Set select options
        SelectHelper::setOptions($this->getHTMLDocument()->getHTMLFactory(), $select, $data['options'], $data['checked_value']);

        return $this;
    }

    /**
     * @param DOMElement $form
     * @param array      $data
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    private function renderForm($form, $data = [])
    {
        // Check for tag name
        if ($form->tagName != 'form') {
            return $this;
        }

        // Set form values
        FormHelper::setValues($this->getHTMLHandler(), $form, $data['values']);

        return $this;
    }

    /**
     * @return HTMLDocument|DOMPrototype
     */
    public function getHTMLDocument()
    {
        return $this->getDOMDocument();
    }

    /**
     * @return HTMLHandlerInterface|DOMHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->getDOMHandler();
    }
}
