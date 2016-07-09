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

namespace Panda\Ui\Contracts\Factories;

use Panda\Ui\Contracts\Handlers\DOMHandlerInterface;
use Panda\Ui\DOMItem;
use Panda\Ui\DOMPrototype;

/**
 * Interface DOMFactoryInterface
 *
 * @package Panda\Ui\Contracts
 *
 * @version 0.1
 */
interface DOMFactoryInterface
{
    /**
     * Build a DOM item.
     *
     * @param string $name
     * @param string $value
     *
     * @return DOMItem
     */
    public function buildElement($name = '', $value = '');

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
