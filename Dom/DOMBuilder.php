<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Dom;

use Exception;

/**
 * Interface DOMBuilder
 * @package Panda\Ui\Dom
 */
interface DOMBuilder
{
    /**
     * Build the element.
     *
     * @return $this
     * @throws Exception
     */
    public function build();
}
