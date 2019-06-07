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
use Exception;
use InvalidArgumentException;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\CssSelector\Exception\SyntaxErrorException;

/**
 * Class FormRender
 * @package Panda\Ui\Html\Renders
 */
class FormRender implements HTMLRenderInterface
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
    public function render(DOMElement &$element, $data = [])
    {
        // Render values
        $this->renderValues($element, $data['form']['values']);

        return $element;
    }

    /**
     * @param DOMElement $element
     * @param array      $values
     *
     * @return DOMElement
     * @throws InvalidArgumentException
     * @throws Exception
     */
    private function renderValues(DOMElement &$element, $values = [])
    {
        foreach ($values as $name => $value) {
            // Normal inputs
            $types = ['text', 'number', 'email', 'hidden', 'password'];
            foreach ($types as $type) {
                $input = $this->getElementBySelector($element, sprintf('input[type="%s"][name="%s"]', $type, $name));
                if (!empty($input)) {
                    $this->getHTMLHandler()->attr($input, 'value', $value);
                }
            }

            // Checkbox
            $types = ['checkbox'];
            foreach ($types as $type) {
                $input = $this->getElementBySelector($element, sprintf('input[type="%s"][name="%s"]', $type, $name));
                if (!empty($input)) {
                    $this->getHTMLHandler()->attr($input, 'checked', $value);
                }
            }

            // Radio
            $types = ['radio'];
            foreach ($types as $type) {
                $input = $this->getElementBySelector($element, sprintf('input[type="%s"][name="%s"][value="%s"]', $type, $name, $value));
                if (!empty($input)) {
                    $this->getHTMLHandler()->attr($input, 'checked', $value);
                }
            }

            // Options in select
            $option = $this->getElementBySelector($element, sprintf('select[name="%s"] option[value="%s"]', $name, $value));
            if (!empty($option)) {
                $this->getHTMLHandler()->attr($option, 'selected', true);
            }

            // Textareas
            $textarea = $this->getElementBySelector($element, sprintf('textarea[name="%s"]', $name));
            if (!empty($textarea)) {
                $this->getHTMLHandler()->innerHTML($textarea, $value);
            }
        }

        return $element;
    }

    /**
     * @param DOMElement $element
     * @param string     $selector
     *
     * @return DOMElement|DOMNode|null
     * @throws InvalidArgumentException
     */
    private function getElementBySelector(DOMElement $element, $selector)
    {
        try {
            return $this->getHTMLHandler()->select($element->ownerDocument, $selector, $element)->item(0);
        } catch (SyntaxErrorException $ex) {
            // Do nothing
        } catch (InternalErrorException $ex) {
            // Do nothing
        }

        return null;
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
