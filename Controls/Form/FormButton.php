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

namespace Panda\Ui\Controls\Form;

use Exception;
use InvalidArgumentException;
use Panda\Ui\Html\HTMLDocument;

/**
 * HTML Form Button
 *
 * Create HTML form items
 *
 * @version    0.1
 */
class FormButton extends FormElement
{
    /**
     * All the accepted button types.
     *
     * @type array
     */
    private $buttonTypes = [
        'button',
        'reset',
        'submit'
    ];

    /**
     * Create a new form button.
     *
     * @param HTMLDocument $HTMLDocument The DOMDocument to create the element
     * @param string       $type         The button's type attribute
     * @param string       $name         The button's name attribute
     * @param string       $id           The button's id attribute
     * @param string       $title        The button's title.
     *
     * @throws Exception
     *
     */
    public function __construct(HTMLDocument $HTMLDocument, $type = "submit", $name = "", $id = "", $title = "")
    {
        // Check input type
        if (!$this->checkType($type))
            throw new InvalidArgumentException("The form button type is not a valid HTML4 or HTML5 button type.");

        // Create HTMLElement
        parent::__construct($HTMLDocument, $itemName = "button", $name, $value = "", $id, $class = "", $title);

        // Add extra attributes
        $this->attr("type", $type);
    }

    /**
     * Checks if the given button type is valid for HTML4 and HTML5.
     *
     * @param string $type The button's type
     *
     * @return bool True if the type is valid, false otherwise.
     */
    private function checkType($type)
    {
        // Check input type
        $expression = implode("|", $this->buttonTypes);
        $valid = preg_match('/^(' . $expression . ')$/', $type);

        return ($valid === 1);
    }
}

?>