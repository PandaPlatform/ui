<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Renders;

use DOMElement;
use DOMNode;
use Exception;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;

/**
 * Class HTMLRender
 * @package Panda\Ui\Html\Handlers
 */
class HTMLRender implements HTMLRenderInterface
{
    /**
     * @var HTMLHandlerInterface
     */
    private $HTMLHandler;

    /**
     * HTMLRender constructor.
     *
     * @param HTMLHandlerInterface $HTMLHandler
     */
    public function __construct(HTMLHandlerInterface $HTMLHandler)
    {
        $this->HTMLHandler = $HTMLHandler;
    }

    /**
     * Render the given DOMElement using the provided data as parameters.
     *
     * @param DOMElement|DOMNode $element The DOMElement to render.
     * @param array              $data    The data to render.
     *
     * @return DOMElement|null
     *
     * @throws Exception
     */
    public function render(DOMElement &$element, $data = [])
    {
        // Check for actions
        $actions = $data['actions'];

        // Check for "delete" action
        if (isset($actions['delete']) && $actions['delete']) {
            $this->getHTMLHandler()->remove($element);

            return null;
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
            $this->getHTMLHandler()->data($element, $name, $value);
        }

        // Apply style attributes
        foreach ($data['style'] as $name => $value) {
            $this->getHTMLHandler()->style($element, $name, $value);
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

        return $element;
    }

    /**
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->HTMLHandler;
    }

    /**
     * @param HTMLHandlerInterface $HTMLHandler
     *
     * @return $this
     */
    public function setHTMLHandler(HTMLHandlerInterface $HTMLHandler)
    {
        $this->HTMLHandler = $HTMLHandler;

        return $this;
    }
}
