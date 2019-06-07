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
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;

/**
 * Class RenderCollection
 * @package Panda\Ui\Html\Renders
 */
class RenderCollection implements RenderCollectionInterface
{
    /**
     * @var HTMLRenderInterface[]
     */
    private $renders;

    /**
     * @var HTMLHandlerInterface
     */
    private $HTMLHandler;

    /**
     * RenderCollection constructor.
     *
     * @param HTMLHandlerInterface $HTMLHandler
     */
    public function __construct(HTMLHandlerInterface $HTMLHandler)
    {
        $this->HTMLHandler = $HTMLHandler;
    }

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
    public function render(DOMDocument &$document, $parameters = [], $context = null)
    {
        // Render all elements that match the given selector
        foreach ($parameters as $selector => $data) {
            $elements = $this->getHTMLHandler()->select($document, $selector, $context);
            foreach ($elements as $element) {
                foreach ($this->getRenders() as $render) {
                    $render->render($element, $data);
                }
            }
        }
    }

    /**
     * @param HTMLRenderInterface $render
     *
     * @return $this
     */
    public function addRender(HTMLRenderInterface $render)
    {
        $this->renders[] = $render;

        return $this;
    }

    /**
     * @param HTMLRenderInterface[] $renders
     *
     * @return $this
     */
    public function setRenders($renders)
    {
        $this->renders = $renders;

        return $this;
    }

    /**
     * @return HTMLRenderInterface[]
     */
    public function getRenders()
    {
        return $this->renders;
    }

    /**
     * @return HTMLHandlerInterface
     */
    public function getHTMLHandler()
    {
        return $this->HTMLHandler;
    }

    /**
     * @param HTMLHandlerInterface $HTMLHandler
     *
     * @return $this
     */
    public function setHTMLHandler(HTMLHandlerInterface $HTMLHandler)
    {
        $this->HTMLHandler = $HTMLHandler;

        return $this;
    }
}
