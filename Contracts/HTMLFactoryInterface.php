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

namespace Panda\Ui\Contracts;

use Panda\Ui\DOMItem;
use Panda\Ui\Html\HTMLElement;

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
     * @return DOMItem
     */
    public function buildElement($name = "", $value = "", $id = "", $class = "");

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
    public function buildMeta($name = "", $content = "", $httpEquiv = "", $charset = "");

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
     * @return mixed
     */
    public function buildScript($src, $async = false);
}

?>