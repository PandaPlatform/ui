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

/**
 * Interface DOMBuilder
 *
 * @package Panda\Ui\Contracts
 *
 * @version 0.1
 */
interface DOMBuilder
{
    /**
     * Build the element.
     *
     * @return $this
     */
    public function build();
}
