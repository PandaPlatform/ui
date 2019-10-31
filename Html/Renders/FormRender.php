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

/**
 * Class FormRender
 * @package Panda\Ui\Html\Renders
 */
class FormRender extends AbstractRender implements HTMLRenderInterface
{
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
                // Remove already selected options
                $selectedOptions = $this->getElementsBySelector($element, sprintf('select[name="%s"] option[selected]', $name));
                foreach ($selectedOptions as $selectedOption) {
                    $this->getHTMLHandler()->attr($selectedOption, 'selected', false);
                }

                // Set current option as selected
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
}
