<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Dom\Factories;

use Panda\Ui\Dom\DOMItem;
use Panda\Ui\Dom\DOMPrototype;
use Panda\Ui\Dom\Handlers\DOMHandlerInterface;

/**
 * Interface DOMFactoryInterface
 * @package Panda\Ui\Dom\Factories
 */
interface DOMFactoryInterface
{
    /**
     * Build a DOM item.
     *
     * @param string $name
     * @param string $value
     * @param string $namespaceURI
     *
     * @return DOMItem
     */
    public function buildElement($name = '', $value = '', $namespaceURI = '');

    /**
     * Get the DOMPrototype for creating objects.
     *
     * @return DOMPrototype
     */
    public function getDOMDocument();

    /**
     * Set the DOMPrototype for creating objects.
     *
     * @param DOMPrototype $DOMDocument
     *
     * @return mixed
     */
    public function setDOMDocument(DOMPrototype $DOMDocument);

    /**
     * Get the DOMHandler for editing the elements.
     *
     * @return DOMHandlerInterface
     */
    public function getDOMHandler();
}
