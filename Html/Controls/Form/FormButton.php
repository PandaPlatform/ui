<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Controls\Form;

use Exception;
use InvalidArgumentException;
use Panda\Ui\Html\HTMLDocument;

/**
 * Class FormButton
 * @package Panda\Ui\Html\Controls\Form
 */
class FormButton extends FormElement
{
    /**
     * All the accepted button types.
     *
     * @var array
     */
    protected $types = [
        'button',
        'reset',
        'submit',
    ];

    /**
     * Create a new form button.
     *
     * @param HTMLDocument $HTMLDocument The button's parent document
     * @param string       $type         The button's type attribute
     * @param string       $name         The button's name attribute
     * @param string       $id           The button's id attribute
     * @param string       $title        The button's title.
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $type = 'submit', $name = '', $id = '', $title = '')
    {
        // Check input type
        if (!$this->checkType($type)) {
            throw new InvalidArgumentException('The form button type is not a valid HTML4 or HTML5 button type.');
        }

        // Create HTMLElement
        parent::__construct($HTMLDocument, $itemName = 'button', $name, $value = '', $id, $class = 'form-button', $title);

        // Add extra attributes
        $this->attr('type', $type);
    }
}
