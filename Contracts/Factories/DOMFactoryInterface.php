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

use Panda\Ui\DOMItem;
use Panda\Ui\DOMPrototype;

/**
 * Interface DOMFactoryInterface
 *
 * @package Panda\Ui\Contracts
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
    public function buildElement($name = "", $value = "");

    /**
     * @return DOMPrototype
     */
    public function getDocument();

    /**
     * @param DOMPrototype $Prototype
     */
    public function setDocument($Prototype);
}

?>