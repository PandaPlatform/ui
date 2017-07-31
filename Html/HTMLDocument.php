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

use DOMNodeList;
use Exception;
use InvalidArgumentException;
use Panda\Ui\Dom\DOMPrototype;
use Panda\Ui\Dom\Factories\DOMFactoryInterface;
use Panda\Ui\Dom\Handlers\DOMHandlerInterface;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\Helpers\HTMLHelper;

/**
 * Class HTMLDocument
 *
 * Magic methods (based on \Panda\Ui\Html\Helpers\HTMLHelper):
 *
 * @method a($value = '', $id = '', $class = '');
 * @method abbr($value = '', $id = '', $class = '');
 * @method acronym($value = '', $id = '', $class = '');
 * @method address($value = '', $id = '', $class = '');
 * @method applet($value = '', $id = '', $class = '');
 * @method area($value = '', $id = '', $class = '');
 * @method article($value = '', $id = '', $class = '');
 * @method aside($value = '', $id = '', $class = '');
 * @method audio($value = '', $id = '', $class = '');
 * @method b($value = '', $id = '', $class = '');
 * @method base($value = '', $id = '', $class = '');
 * @method basefont($value = '', $id = '', $class = '');
 * @method bdi($value = '', $id = '', $class = '');
 * @method bdo($value = '', $id = '', $class = '');
 * @method big($value = '', $id = '', $class = '');
 * @method blockquote($value = '', $id = '', $class = '');
 * @method body($value = '', $id = '', $class = '');
 * @method br($value = '', $id = '', $class = '');
 * @method button($value = '', $id = '', $class = '');
 * @method canvas($value = '', $id = '', $class = '');
 * @method caption($value = '', $id = '', $class = '');
 * @method center($value = '', $id = '', $class = '');
 * @method cite($value = '', $id = '', $class = '');
 * @method code($value = '', $id = '', $class = '');
 * @method col($value = '', $id = '', $class = '');
 * @method colgroup($value = '', $id = '', $class = '');
 * @method datalist($value = '', $id = '', $class = '');
 * @method dd($value = '', $id = '', $class = '');
 * @method del($value = '', $id = '', $class = '');
 * @method details($value = '', $id = '', $class = '');
 * @method dfn($value = '', $id = '', $class = '');
 * @method dialog($value = '', $id = '', $class = '');
 * @method dir($value = '', $id = '', $class = '');
 * @method div($value = '', $id = '', $class = '');
 * @method dl($value = '', $id = '', $class = '');
 * @method dt($value = '', $id = '', $class = '');
 * @method em($value = '', $id = '', $class = '');
 * @method embed($value = '', $id = '', $class = '');
 * @method fieldset($value = '', $id = '', $class = '');
 * @method figcaption($value = '', $id = '', $class = '');
 * @method figure($value = '', $id = '', $class = '');
 * @method font($value = '', $id = '', $class = '');
 * @method footer($value = '', $id = '', $class = '');
 * @method form($value = '', $id = '', $class = '');
 * @method frame($value = '', $id = '', $class = '');
 * @method frameset($value = '', $id = '', $class = '');
 * @method h1($value = '', $id = '', $class = '');
 * @method h2($value = '', $id = '', $class = '');
 * @method h3($value = '', $id = '', $class = '');
 * @method h4($value = '', $id = '', $class = '');
 * @method h5($value = '', $id = '', $class = '');
 * @method h6($value = '', $id = '', $class = '');
 * @method head($value = '', $id = '', $class = '');
 * @method header($value = '', $id = '', $class = '');
 * @method hr($value = '', $id = '', $class = '');
 * @method html($value = '', $id = '', $class = '');
 * @method i($value = '', $id = '', $class = '');
 * @method iframe($value = '', $id = '', $class = '');
 * @method image($value = '', $id = '', $class = '');
 * @method input($value = '', $id = '', $class = '');
 * @method ins($value = '', $id = '', $class = '');
 * @method kbd($value = '', $id = '', $class = '');
 * @method keygen($value = '', $id = '', $class = '');
 * @method label($value = '', $id = '', $class = '');
 * @method legend($value = '', $id = '', $class = '');
 * @method li($value = '', $id = '', $class = '');
 * @method link($value = '', $id = '', $class = '');
 * @method main($value = '', $id = '', $class = '');
 * @method map($value = '', $id = '', $class = '');
 * @method mark($value = '', $id = '', $class = '');
 * @method menu($value = '', $id = '', $class = '');
 * @method menuitem($value = '', $id = '', $class = '');
 * @method meta($value = '', $id = '', $class = '');
 * @method meter($value = '', $id = '', $class = '');
 * @method nav($value = '', $id = '', $class = '');
 * @method noframes($value = '', $id = '', $class = '');
 * @method noscript($value = '', $id = '', $class = '');
 * @method object($value = '', $id = '', $class = '');
 * @method ol($value = '', $id = '', $class = '');
 * @method optgroup($value = '', $id = '', $class = '');
 * @method option($value = '', $id = '', $class = '');
 * @method output($value = '', $id = '', $class = '');
 * @method p($value = '', $id = '', $class = '');
 * @method param($value = '', $id = '', $class = '');
 * @method pre($value = '', $id = '', $class = '');
 * @method progress($value = '', $id = '', $class = '');
 * @method q($value = '', $id = '', $class = '');
 * @method rp($value = '', $id = '', $class = '');
 * @method rt($value = '', $id = '', $class = '');
 * @method ruby($value = '', $id = '', $class = '');
 * @method s($value = '', $id = '', $class = '');
 * @method samp($value = '', $id = '', $class = '');
 * @method script($value = '', $id = '', $class = '');
 * @method section($value = '', $id = '', $class = '');
 * @method select($value = '', $id = '', $class = '');
 * @method small($value = '', $id = '', $class = '');
 * @method source($value = '', $id = '', $class = '');
 * @method span($value = '', $id = '', $class = '');
 * @method strike($value = '', $id = '', $class = '');
 * @method strong($value = '', $id = '', $class = '');
 * @method style($value = '', $id = '', $class = '');
 * @method sub($value = '', $id = '', $class = '');
 * @method summary($value = '', $id = '', $class = '');
 * @method sup($value = '', $id = '', $class = '');
 * @method table($value = '', $id = '', $class = '');
 * @method tbody($value = '', $id = '', $class = '');
 * @method td($value = '', $id = '', $class = '');
 * @method textarea($value = '', $id = '', $class = '');
 * @method tfoot($value = '', $id = '', $class = '');
 * @method th($value = '', $id = '', $class = '');
 * @method thead($value = '', $id = '', $class = '');
 * @method time($value = '', $id = '', $class = '');
 * @method title($value = '', $id = '', $class = '');
 * @method tr($value = '', $id = '', $class = '');
 * @method track($value = '', $id = '', $class = '');
 * @method tt($value = '', $id = '', $class = '');
 * @method u($value = '', $id = '', $class = '');
 * @method ul($value = '', $id = '', $class = '');
 * @method var($value = '', $id = '', $class = '');
 * @method video($value = '', $id = '', $class = '');
 * @method wbr($value = '', $id = '', $class = '');
 *
 * @package Panda\Ui\Html
 */
class HTMLDocument extends DOMPrototype
{
    /**
     * Create a new DOM Document.
     *
     * @param HTMLHandlerInterface $HTMLHandler
     * @param HTMLFactoryInterface $HTMLFactory
     * @param string               $version
     * @param string               $encoding
     */
    public function __construct(HTMLHandlerInterface $HTMLHandler, HTMLFactoryInterface $HTMLFactory, $version = '1.0', $encoding = 'UTF_8')
    {
        // Construct DOMDocument
        parent::__construct($HTMLHandler, $HTMLFactory, $version, $encoding);
    }

    /**
     * Creates and returns a DOMElement with the specified tagName and the given attributes
     *
     * @param string $name  The tag of the element.
     * @param mixed  $value The content of the element. It can be a string or a DOMElement.
     * @param string $id    The id attribute
     * @param string $class The class attribute
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function create($name = 'div', $value = '', $id = '', $class = '')
    {
        // Create a new HTMLElement
        return $this->getHTMLFactory()->buildHtmlElement($name, $value, $id, $class);
    }

    /**
     * Magic method to create all html tags automatically.
     *
     * @param string $name      The function name caught.
     *                          In this function it serves as the tag name.
     * @param array  $arguments All function arguments.
     *                          They serve as the content, id and class, like DOM::create().
     *
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        // Get method name and check for a valid html tag
        $name = strtolower($name);
        if (!HTMLHelper::validHtmlTag($name)) {
            throw new InvalidArgumentException(__METHOD__ . ': The given tag name is invalid.');
        }

        // Get rest of attributes
        $value = (count($arguments) > 0 ? $arguments[0] : '');
        $id = (count($arguments) > 1 ? $arguments[1] : '');
        $class = (count($arguments) > 2 ? $arguments[2] : '');

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
     * @return DOMNodeList|false
     * @throws InvalidArgumentException
     */
    public function selectElement($selector, $context = null)
    {
        return $this->getHTMLHandler()->select($this, $selector, $context);
    }

    /**
     * Returns the HTML form of the document.
     *
     * @param bool $format Indicates whether to format the output.
     *
     * @return string The html generated by this document.,
     */
    public function getHTML($format = false)
    {
        $this->formatOutput = $format;

        return $this->saveHTML();
    }

    /**
     * @return HTMLHandlerInterface|DOMHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->getDOMHandler();
    }

    /**
     * @return HTMLFactoryInterface|DOMFactoryInterface
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
