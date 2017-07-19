<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Factories;

use Exception;
use Panda\Ui\Dom\DOMPrototype;
use Panda\Ui\Dom\Factories\DOMFactory;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Class HTMLFactory
 * @package Panda\Ui\Factories
 */
class HTMLFactory extends DOMFactory implements HTMLFactoryInterface
{
    /**
     * Build an HTML Element.
     *
     * @param string $name  The element's tagName.
     * @param string $value The element's content value.
     * @param string $id    The elements id attribute.
     * @param string $class The element's class attribute.
     *
     * @return HTMLElement
     */
    public function buildHtmlElement($name = '', $value = '', $id = '', $class = '')
    {
        return new HTMLElement($this->getHTMLDocument(), $name, $value, $id, $class);
    }

    /**
     * Build an HTML weblink <a> element.
     *
     * @param string $href    The weblink href attribute.
     * @param string $target  The weblink target attribute.
     * @param string $content The weblink element content value.
     * @param string $id      The weblink id attribute.
     * @param string $class   The weblink class attribute.
     *
     * @return HTMLElement
     *
     * @throws Exception
     */
    public function buildWebLink($href = '', $target = '_self', $content = '', $id = '', $class = '')
    {
        // Create webLink element
        $webLink = $this->buildHtmlElement($name = 'a', $content, $id, $class);

        // Add attributes
        $webLink->attr('href', $href);
        $webLink->attr('target', $target);

        // Return the webLink
        return $webLink;
    }

    /**
     * Build a meta element.
     *
     * @param string $name      The meta name attribute.
     * @param string $content   The meta content attribute.
     * @param string $httpEquiv The meta http-equiv attribute.
     * @param string $charset   The meta charset attribute.
     *
     * @return HTMLElement
     *
     * @throws Exception
     */
    public function buildMeta($name = '', $content = '', $httpEquiv = '', $charset = '')
    {
        // Create meta element
        $meta = $this->buildHtmlElement('meta', $value = '', $id = '', $class = '');
        $meta->attr('name', $name);
        $meta->attr('http-equiv', $httpEquiv);
        $meta->attr('content', htmlspecialchars($content));
        $meta->attr('charset', $charset);

        // Return element
        return $meta;
    }

    /**
     * Build an html link element.
     *
     * @param string $rel  The link rel attribute.
     * @param string $href The link href attribute.
     *
     * @return HTMLElement
     *
     * @throws Exception
     */
    public function buildLink($rel, $href)
    {
        // Build the link element
        $link = $this->buildHtmlElement($name = 'link', $value = '', $id = '', $class = '');
        $link->attr('rel', $rel);
        $link->attr('href', $href);

        // Return link
        return $link;
    }

    /**
     * Build an html script element.
     *
     * @param string $src   The script src attribute.
     * @param bool   $async The script async attribute.
     *
     * @return HTMLElement
     *
     * @throws Exception
     */
    public function buildScript($src, $async = false)
    {
        // Build the script element
        $script = $this->buildHtmlElement($name = 'script', $value = '', $id = '', $class = '');
        $script->attr('src', $src);
        $script->attr('async', $async);

        // Return the script
        return $script;
    }

    /**
     * @return HTMLDocument|DOMPrototype
     */
    public function getHTMLDocument()
    {
        return $this->getDOMDocument();
    }

    /**
     * Set the HTMLDocument for creating html objects.
     *
     * @param HTMLDocument $HTMLDocument
     *
     * @return $this
     */
    public function setHTMLDocument(HTMLDocument $HTMLDocument)
    {
        return $this->setDOMDocument($HTMLDocument);
    }

    /**
     * Get the HTMLHandler for editing the elements.
     *
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->getHTMLDocument()->getHTMLHandler();
    }
}
