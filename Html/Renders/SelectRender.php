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
use Panda\Ui\Html\Factories\HTMLFactoryInterface;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;

/**
 * Class SelectRender
 *
 * @package Panda\Ui\Html\Renders
 */
class SelectRender extends AbstractRender implements HTMLRenderInterface
{
    /**
     * @var HTMLFactoryInterface
     */
    private $HTMLFactory;

    /**
     * SelectRender constructor.
     *
     * @param HTMLHandlerInterface $HTMLHandler
     * @param HTMLFactoryInterface $HTMLFactory
     */
    public function __construct(HTMLHandlerInterface $HTMLHandler, HTMLFactoryInterface $HTMLFactory)
    {
        parent::__construct($HTMLHandler);
        $this->HTMLFactory = $HTMLFactory;
    }

    /**
     * Render the given DOMElement using the provided data as parameters.
     *
     * @param DOMElement|DOMNode $element The DOMElement to render.
     * @param array              $data    The data to render.
     *
     * @return DOMElement|null|bool
     *
     * @throws Exception
     */
    public function render(DOMElement &$element, $data = [])
    {
        // Check for tag name
        if ($element->tagName != 'select') {
            return false;
        }

        // Render groups
        $this->renderGroups($element, $data['select']['groups'], $data['select']['checked_value']);

        // Render options
        $this->renderOptions($element, $data['select']['options'], $data['select']['checked_value']);

        return $element;
    }

    /**
     * @param DOMElement $element
     * @param array      $groups
     * @param null       $checkedValue
     *
     * @throws InvalidArgumentException
     */
    private function renderGroups(DOMElement &$element, $groups = [], $checkedValue = null)
    {
        foreach ($groups as $data) {
            $label = $data['label'];
            $options = $data['options'];

            // Build group
            $group = $this->getHTMLFactory()->buildHtmlElement('optgroup', '', '', '', [
                'label' => $label,
            ]);

            // Add options to group
            $this->renderOptions($group, $options, $checkedValue);

            // Append group to container
            $this->getHTMLHandler()->append($element, $group);
        }
    }

    /**
     * @param DOMElement $element
     * @param array      $options
     * @param null       $checkedValue
     *
     * @throws InvalidArgumentException
     * @throws Exception
     */
    private function renderOptions(DOMElement &$element, $options = [], $checkedValue = null)
    {
        foreach ($options as $value => $title) {
            // Build option
            $option = $this->getHTMLFactory()->buildHtmlElement('option', $title);
            $option->attr('value', $value);

            // Append option to container
            $this->getHTMLHandler()->append($element, $option);
        }
        // Remove already selected options first
        if (!is_null($checkedValue)) {
            $selectedOptions = $this->getElementsBySelector($element, 'option[selected]');
            foreach ($selectedOptions as $selectedOption) {
                $this->getHTMLHandler()->attr($selectedOption, 'selected', false);
            }
        }

        // Set checked values
        $checkedValues = is_array($checkedValue) ? $checkedValue : [$checkedValue];
        foreach ($checkedValues as $value) {
            // Skip empty values
            if ($value === '' || is_null($value)) {
                continue;
            }

            // Select option
            $option = $this->getElementBySelector($element, sprintf('option[value="%s"]', $value));
            if ($option) {
                $this->getHTMLHandler()->attr($option, 'selected', 'selected');
            }
        }
    }

    /**
     * @return HTMLFactoryInterface
     */
    public function getHTMLFactory()
    {
        return $this->HTMLFactory;
    }

    /**
     * @param HTMLFactoryInterface $HTMLFactory
     *
     * @return $this
     */
    public function setHTMLFactory(HTMLFactoryInterface $HTMLFactory)
    {
        $this->HTMLFactory = $HTMLFactory;

        return $this;
    }
}
