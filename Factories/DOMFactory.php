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

namespace Panda\Ui\Factories;

use Panda\Ui\Contracts\Factories\DOMFactoryInterface;
use Panda\Ui\Contracts\Handlers\DOMHandlerInterface;
use Panda\Ui\DOMItem;
use Panda\Ui\DOMPrototype;

/**
 * Class DOMFactory
 *
 * @package Panda\Ui\Factories
 *
 * @version 0.1
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
     *
     * @return DOMItem
     */
    public function buildElement($name = '', $value = '')
    {
        return new DOMItem($this->getDOMDocument(), $name, $value);
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
