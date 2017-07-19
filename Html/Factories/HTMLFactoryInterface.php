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

use Panda\Ui\Dom\Factories\DOMFactoryInterface;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Interface HTMLFactoryInterface
 * @package Panda\Ui\Html\Factories
 */
interface HTMLFactoryInterface extends DOMFactoryInterface
{
    /**
     * Build a DOM item.
     *
     * @param string $name
     * @param string $value
     * @param string $id
     * @param string $class
     *
     * @return HTMLElement
     */
    public function buildElement($name = '', $value = '', $id = '', $class = '');

    /**
     * Build an HTML weblink <a> element.
     *
     * @param string $href
     * @param string $target
     * @param string $content
     * @param string $id
     * @param string $class
     *
     * @return HTMLElement
     */
    public function buildWebLink($href = '', $target = '_self', $content = '', $id = '', $class = '');

    /**
     * Build a meta element.
     *
     * @param string $name
     * @param string $content
     * @param string $httpEquiv
     * @param string $charset
     *
     * @return HTMLElement
     */
    public function buildMeta($name = '', $content = '', $httpEquiv = '', $charset = '');

    /**
     * Build an html link element.
     *
     * @param string $rel
     * @param string $href
     *
     * @return HTMLElement
     */
    public function buildLink($rel, $href);

    /**
     * Build an html script element.
     *
     * @param string $src
     * @param bool   $async
     *
     * @return HTMLElement
     */
    public function buildScript($src, $async = false);

    /**
     * Get the HTMLDocument for creating html objects.
     *
     * @return HTMLDocument
     */
    public function getHTMLDocument();

    /**
     * Set the HTMLDocument for creating html objects.
     *
     * @param HTMLDocument $HTMLDocument
     *
     * @return mixed
     */
    public function setHTMLDocument(HTMLDocument $HTMLDocument);

    /**
     * Get the HTMLHandler for editing the elements.
     *
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler();
}
