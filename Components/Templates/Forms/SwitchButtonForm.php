<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Components\Templates\Forms;

use Exception;
use InvalidArgumentException;
use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Components\Controls\Form\SwitchButton;

/**
 * Class SwitchButtonForm
 * @package Panda\Ui\Html\Templates\Forms
 */
class SwitchButtonForm extends Form implements DOMBuilder
{
    /**
     * @param string $id
     * @param string $action
     * @param bool   $async
     * @param bool   $fileUpload
     * @param bool   $active
     * @param string $itemName
     * @param string $itemValue
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($id = '', $action = '', $async = true, $fileUpload = false, $active = false, $itemName = '', $itemValue = '')
    {
        // Build form container
        parent::build($id, $action, $async = true, $fileUpload);
        $this->addClass('uiSwitchButtonForm');

        // Build switch button
        $sbf = new SwitchButton($this->getHTMLDocument(), $active, 'sbf');
        $sbf->build($itemName, $itemValue);
        $this->append($sbf);

        return $this;
    }

    /**
     * Get a status event for async control of the element.
     *
     * @param bool $status
     *
     * @return array
     */
    public static function getStatusEvent($status = true)
    {
        // Set action status
        $action = ($status ? 'on' : 'off');

        return ['name' => 'switch.' . $action];
    }
}
