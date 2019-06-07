<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Renders;

use DOMDocument;
use Exception;
use InvalidArgumentException;

/**
 * Interface RenderCollectionInterface
 * @package Panda\Ui\Html\Renders
 */
interface RenderCollectionInterface
{
    /**
     * Render the given DOMDocument using a set of Render Handlers.
     *
     * @param DOMDocument $document   The owner document of the HTML to render
     * @param array       $parameters The parameters to render.
     * @param mixed       $context
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function render(DOMDocument &$document, $parameters = [], $context = null);
}
