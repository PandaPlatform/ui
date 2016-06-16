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
use Panda\Ui\DOMItem;

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
     * Build a DOM item.
     *
     * @param string $name
     * @param string $value
     *
     * @return DOMItem
     *
     */
    public function buildElement($name = '', $value = '')
    {
        return new DOMItem($name, $value);
    }
}

