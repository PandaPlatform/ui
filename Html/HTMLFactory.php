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
use Panda\Ui\Contracts\HTMLFactoryInterface;
use Panda\Ui\DOMFactory;

/**
 * Class HTMLFactory
 *
 * @package Panda\Ui\Html
 */
class HTMLFactory extends DOMFactory implements HTMLFactoryInterface
{
    /***
     * @type HTMLDocument
     */
    protected $Document;

    /**
     * HTMLFactory constructor.
     *
     * @param HTMLDocument|null $Document
     */
    public function __construct($Document = null)
    {
        // Initialize current HTMLDocument
        $this->Document = $Document;

        // Construct DOMFactory
        parent::__construct($Document);
    }

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
    public function buildElement($name = "", $value = "", $id = "", $class = "")
    {
        return (new HTMLElement($this->Document, $name, $value, $id, $class));
    }

    /**
     * Build an HTML weblink <a> element.
     *
     * @param string $href    The weblink's href attribute.
     * @param string $target  The weblink's target attribute.
     * @param string $content The weblink's element content value.
     * @param string $id      The weblinkt's id attribute.
     * @param string $class   The weblinkt's class attribute.
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function buildWeblink($href = "", $target = "_self", $content = "", $id = "", $class = "")
    {
        // Create weblink element
        $weblink = $this->buildElement($name = "a", $content, $id, $class);

        // Add attributes
        $weblink->attr("href", $href);
        $weblink->attr("target", $target);

        // Return the weblink
        return $weblink;
    }

    /**
     * Build a meta element.
     *
     * @param string $name      The meta's name attribute.
     * @param string $content   The meta's content attribute.
     * @param string $httpEquiv The meta's http-equiv attribute.
     * @param string $charset   The meta's charset attribute.
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function buildMeta($name = "", $content = "", $httpEquiv = "", $charset = "")
    {
        // Create meta element
        $meta = $this->getDocument()->create('meta');
        $meta->attr("name", $name);
        $meta->attr("http-equiv", $httpEquiv);
        $meta->attr("content", htmlspecialchars($content));
        $meta->attr("charset", $charset);

        // Return element
        return $meta;
    }

    /**
     * Build an html link element.
     *
     * @param string $rel  The link's rel attribute.
     * @param string $href The link's href attribute.
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function buildLink($rel, $href)
    {
        // Build the link element
        $link = $this->getDocument()->create("link");
        $link->attr($link, "rel", $rel);
        $link->attr($link, "href", $href);

        // Return link
        return $link;
    }

    /**
     * Build an html script element.
     *
     * @param string $src   The script's src attribute.
     * @param bool   $async The script's async attribute.
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function buildScript($src, $async = false)
    {
        // Build the script element
        $script = $this->getDocument()->create("script");
        $script->attr($script, "src", $src);
        $script->attr($script, "async", $async);

        // Return the script
        return $script;
    }

    /**
     * @return HTMLDocument
     */
    public function getDocument()
    {
        return $this->Document;
    }

    /**
     * @param HTMLDocument $Document
     */
    public function setDocument($Document)
    {
        $this->Document = $Document;
    }
}

?>