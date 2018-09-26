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
 * Class DOMFactory
 * @package Panda\Ui\Dom\Factories
 */
class DOMFactory implements DOMFactoryInterface
{
    /**
     * @var DOMPrototype
     */
    protected $DOMDocument;

    /**
     * Build a DOM item.
     *
     * @param string $name
     * @param string $value
     * @param string $namespaceURI
     * @param array  $attributes
     *
     * @return DOMItem
     * @throws \InvalidArgumentException
     */
    public function buildElement($name = '', $value = '', $namespaceURI = '', $attributes = [])
    {
        return new DOMItem($this->getDOMDocument(), $name, $value, $namespaceURI, $attributes);
    }

    /**
     * @return DOMPrototype
     */
    public function getDOMDocument()
    {
        return $this->DOMDocument;
    }

    /**
     * @param DOMPrototype $DOMDocument
     *
     * @return $this
     */
    public function setDOMDocument(DOMPrototype $DOMDocument)
    {
        $this->DOMDocument = $DOMDocument;

        return $this;
    }

    /**
     * Get the DOMHandler for editing the elements.
     *
     * @return DOMHandlerInterface
     */
    public function getDOMHandler()
    {
        return $this->getDOMDocument()->getDOMHandler();
    }
}
