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
 * Class FormInput
 * @package Panda\Ui\Html\Controls\Form
 */
class FormInput extends FormElement
{
    /**
     * All the accepted input types.
     *
     * @var array
     */
    protected $types = [
        'button',
        'checkbox',
        'file',
        'hidden',
        'image',
        'password',
        'radio',
        'reset',
        'submit',
        'text',
        'color',
        'date',
        'datetime',
        'datetime-local',
        'email',
        'month',
        'number',
        'range',
        'search',
        'tel',
        'time',
        'url',
        'week',
    ];

    /**
     * Create a new form input item.
     *
     * @param HTMLDocument $HTMLDocument The input's parent document
     * @param string       $type         The input's type
     * @param string       $name         The input's name
     * @param string       $id           The input's id
     * @param string       $class        The input's class
     * @param string       $value        The input's value
     * @param bool         $required     Sets the input as required for the form.
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $type = 'text', $name = '', $id = '', $class = '', $value = '', $required = false)
    {
        // Check input type
        if (!$this->checkType($type)) {
            throw new InvalidArgumentException('The form input type is not a valid HTML4 or HTML5 input type.');
        }

        // Check if input is radio or checkbox
        $checked = false;
        if ($type == 'checkbox' && is_bool($value)) {
            $checked = ($value === true);
            $value = '1';
        }

        // Create HTMLElement
        parent::__construct($HTMLDocument, $itemName = 'input', $name, $value, $id, $class, $itemValue = '');

        // Add extra attributes
        $this->attr('type', $type);
        $this->attr('checked', $checked);
        $this->attr('required', $required);
    }
}
