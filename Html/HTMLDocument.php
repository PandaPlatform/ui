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

use DOMNodeList;
use Exception;
use Panda\Ui\Contracts\Factories\HTMLFactoryInterface;
use Panda\Ui\Contracts\Handlers\HTMLHandlerInterface;
use Panda\Ui\DOMPrototype;
use Panda\Ui\Helpers\HTMLHelper;
use Symfony\Component\CssSelector\CssSelectorConverter;

/**
 * HTML Document Class
 * Create an HTML specific DOMDocument.
 *
 * @package Panda\Ui\Html
 *
 * @version 0.1
 */
class HTMLDocument extends DOMPrototype
{
    /**
     * Create a new DOM Document.
     *
     * @param HTMLFactoryInterface $HTMLFactory
     * @param HTMLHandlerInterface $HTMLHandler
     * @param string               $version
     * @param string               $encoding
     */
    public function __construct(HTMLFactoryInterface $HTMLFactory, HTMLHandlerInterface $HTMLHandler, $version = '1.0', $encoding = 'UTF_8')
    {
        // Construct DOMDocument
        parent::__construct($HTMLFactory, $HTMLHandler, $version, $encoding);

        // Set HTMLHandler for the factory
        $this->getHTMLFactory()->setHTMLHandler($HTMLHandler);
    }

    /**
     * Creates and returns a DOMElement with the specified tagName and the given attributes
     *
     * @param string $name  The tag of the element.
     * @param mixed  $value The content of the element. It can be a string or a DOMElement.
     * @param string $id    The id attribute
     * @param string $class The class attribute
     *
     * @return HTMLElement The HTMLElement created
     *
     * @throws Exception
     */
    public function create($name = 'div', $value = '', $id = '', $class = '')
    {
        // Create a new HTMLElement
        return $this->getHTMLFactory()->buildElement($name, $value, $id, $class);
    }

    /**
     * Magic method to create all html tags automatically.
     *
     * @param string $name      The function name caught.
     *                          In this function it serves as the tag name.
     * @param array  $arguments All function arguments.
     *                          They serve as the content, id and class, like DOM::create().
     *
     * @return mixed The DOMElement created or Null if the tag is not valid.
     */
    public function __call($name, $arguments)
    {
        // Get method name and check for a valid html tag
        $name = strtolower($name);
        if (!HTMLHelper::validHtmlTag($name)) {
            return null;
        }

        // Get rest of attributes
        $value = (count($arguments) > 0 ? $arguments[0] : '');
        $id = (count($arguments) > 0 ? $arguments[1] : '');
        $class = (count($arguments) > 1 ? $arguments[2] : '');

        // Create element
        return $this->create($name, $value, $id, $class);
    }

    /**
     * Selects nodes in the html document that match a given css selector.
     *
     * @param string $selector The css selector to search for in the html document.
     *                         It does not support pseudo-* for the moment and only supports simple equality
     *                         attribute-wise. Can hold multiple selectors separated with comma.
     * @param mixed  $context  Can either be a DOMElement as the context of the search, or a css selector.
     *                         If the selector results in multiple DOMNodes, then the first is selected as the context.
     *                         It is NULL by default.
     *
     * @return DOMNodeList|false Returns the node list that matches the given css selector, or FALSE on malformed input.
     */
    public function select($selector, $context = null)
    {
        // Get xpath from css selector
        $converter = new CssSelectorConverter();
        $xpath = $converter->toXPath($selector);

        // Get the context node if css context
        if (!empty($context) && is_string($context)) {
            $ctxList = self::select($context);
            if (empty($ctxList) || empty($ctxList->length)) {
                return false;
            }

            $context = $ctxList->item(0);
        }

        // Evaluate xpath and return the node list
        return $this->evaluate($xpath, $context);
    }

    /**
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->getDOMHandler();
    }

    /**
     * @return HTMLFactoryInterface
     */
    public function getHTMLFactory()
    {
        return $this->getDOMFactory();
    }

    /**
     * @param HTMLFactoryInterface $HTMLFactory
     *
     * @return $this
     */
    public function setHTMLFactory($HTMLFactory)
    {
        return $this->setDOMFactory($HTMLFactory);
    }
}

