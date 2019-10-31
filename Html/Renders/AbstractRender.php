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

use DOMElement;
use DOMNode;
use DOMNodeList;
use Exception;
use InvalidArgumentException;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\CssSelector\Exception\SyntaxErrorException;

/**
 * Class AbstractRender
 * @package Panda\Ui\Html\Renders
 */
abstract class AbstractRender implements HTMLRenderInterface
{
    /**
     * @var HTMLHandlerInterface
     */
    private $HTMLHandler;

    /**
     * FormRender constructor.
     *
     * @param HTMLHandlerInterface $HTMLHandler
     */
    public function __construct(HTMLHandlerInterface $HTMLHandler)
    {
        $this->HTMLHandler = $HTMLHandler;
    }

    /**
     * Render the given DOMElement using the provided data as parameters.
     *
     * @param DOMElement|DOMNode $element The DOMElement to render.
     * @param array              $data    The data to render.
     *
     * @return DOMElement|null
     *
     * @throws Exception
     */
    abstract public function render(DOMElement &$element, $data = []);

    /**
     * @param DOMElement $element
     * @param string     $selector
     * @param bool       $setElementAsContext
     *
     * @return DOMElement|DOMNode|null
     * @throws InvalidArgumentException
     */
    protected function getElementBySelector(DOMElement $element, $selector, $setElementAsContext = true)
    {
        return $this->getElementsBySelector($element, $selector, $setElementAsContext)->item(0);
    }

    /**
     * @param DOMElement $element
     * @param string     $selector
     * @param bool       $setElementAsContext
     *
     * @return DOMNodeList
     * @throws InvalidArgumentException
     */
    protected function getElementsBySelector(DOMElement $element, $selector, $setElementAsContext = true)
    {
        try {
            return $this->getHTMLHandler()->select($element->ownerDocument, $selector, $setElementAsContext ? $element : null);
        } catch (SyntaxErrorException $ex) {
            // Do nothing
        } catch (InternalErrorException $ex) {
            // Do nothing
        }

        return new DOMNodeList();
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
