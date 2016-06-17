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

namespace Panda\Ui\Html\Popups;

use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Class Popup
 *
 * @package Panda\Ui\Html\Popups
 *
 * @version 0.1
 */
class Popup extends HTMLElement implements DOMBuilder
{
    const TP_OBEDIENT = 'obedient';
    const TP_PERSISTENT = 'persistent';
    const TP_TOGGLE = 'toggle';
    const OR_HORIZONTAL = 'horizontal';
    const OR_VERTIVAL = 'vertical';
    const OR_BOTH = 'both';

    /**
     * 'on', 'one'
     *
     * @var string
     */
    protected $binding = 'on';

    /**
     * 'obedient', 'persistent', 'toggle'
     *
     * @var string
     */
    protected $type = 'obedient';
    /**
     * Defines whether the popup will be dismissed after 3 seconds.
     *
     * @var bool
     */
    protected $timeout = false;

    /**
     * Defines whether the popup will be in a white background.
     *
     * @var bool
     */
    protected $background = false;

    /**
     * Defines whether the popup will have fade transition for in and out.
     *
     * @var bool
     */
    protected $fade = false;

    /**
     * Defines the position of the popup relative to the window|parent|sender.
     *
     * @var string
     */
    protected $position = 'user';

    /**
     * In case of positioning relative to the sender, the offset of the popup in distance from the sender in pixels.
     *
     * @var int
     */
    protected $distanceOffset = 0;

    /**
     * In case of positioning relative to the sender, the offset of the popup in alignment from the sender in pixels.
     *
     * @var int
     */
    protected $alignOffset = 0;

    /**
     * Defines the docking of the popup.
     *
     * @var string
     */
    protected $invertDock = 'none';

    /**
     * Popup id
     *
     * @var string
     */
    protected $popupId = '';

    /**
     * Parent's id
     *
     * @var string
     */
    protected $parent = '';

    /**
     * Popup constructor.
     *
     * @param HTMLDocument $HTMLDocument
     * @param string       $id
     */
    public function __construct(HTMLDocument $HTMLDocument, $id = '')
    {
        // Create object
        parent::__construct($HTMLDocument, $name = 'div', $value = '', $id, 'uiPopup');
    }

    /**
     * Builds the popup according to settings given.
     * The settings must be defined before the build function.
     *
     * @param HTMLElement $content The content of the popup.
     *
     * @return $this
     */
    public function build($content = null)
    {
        // Create the instructions holder
        $info = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'info init');
        $this->append($info);

        // Set attributes
        $settings = [];
        $settings['binding'] = $this->binding;
        $settings['type'] = $this->type;
        $settings['timeout'] = ($this->timeout ?: false);
        $settings['background'] = ($this->background ?: false);
        $settings['fade'] = ($this->fade ?: false);
        $info->data('popup-settings', $settings);

        $extra = [];
        $extra['id'] = $this->popupId;
        $extra['parentid'] = $this->parent;
        $extra['position'] = $this->position;
        $extra['distanceOffset'] = $this->distanceOffset;
        $extra['alignOffset'] = $this->alignOffset;
        $extra['invertDock'] = $this->invertDock;
        $info->data('popup-extra', $extra);

        // Create the popup content holder
        $innerContent = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', $content, '', 'popupContent');
        $this->append($innerContent);

        return $this;
    }

    /**
     * Gets or defines the binding property.
     *
     * @param string $binding The binding value. Can be either 'on' or 'one', like jQuery listeners.
     *                        'On' listens all the time.
     *                        'One' listens only the first time.
     *
     * @return mixed The binding property, or $this.
     */
    public function binding($binding = '')
    {
        // Return value
        if (empty($binding)) {
            return $this->binding;
        }

        // Set value
        $this->binding = $binding;

        return $this;
    }

    /**
     * Gets or defines the popup's parent id.
     *
     * @param string $id The parent's id.
     *
     * @return mixed The popup's parent id, or $this.
     */
    public function parent($id = '')
    {
        // Return value
        if (empty($id)) {
            return $this->parent;
        }

        // Set value
        $this->parent = $id;

        return $this;
    }

    /**
     * Gets or defines the type property.
     *
     * @param string $type   The type value.
     *                       You can use TP_OBEDIENT or TP_PERSISTENT.
     * @param bool   $toggle Toggle functionality for popup.
     *                       This defines that the popup will be showed and hide by the same listener.
     *
     * @return mixed The type property, or $this.
     */
    public function type($type = '', $toggle = false)
    {
        // Return value
        if (empty($type)) {
            return $this->type;
        }

        // Set value
        $this->type = $type . ($toggle === true ? ' ' . self::TP_TOGGLE : '');

        return $this;
    }

    /**
     * Gets or defines the timeout property.
     *
     * @param bool $timeout True to set timeout, false otherwise.
     *
     * @return mixed The timeout property, or $this.
     */
    public function timeout($timeout = null)
    {
        // Return value
        if (empty($timeout)) {
            return $this->timeout;
        }

        // Set value
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Gets or defines the background property.
     *
     * @param bool $background True to set background overlay, false otherwise.
     *
     * @return mixed The background property, or $this.
     */
    public function background($background = null)
    {
        // Return value
        if (is_null($background)) {
            return $this->background;
        }

        // Set value
        $this->background = $background;

        return $this;
    }

    /**
     * Gets or defines the fade property.
     *
     * @param bool $fade True to set fade animation in and out, false otherwise.
     *
     * @return mixed The fade property, or $this.
     */
    public function fade($fade = null)
    {
        // Return value
        if (is_null($fade)) {
            return $this->fade;
        }

        // Set value
        $this->fade = $fade;

        return $this;
    }

    /**
     * Gets or defines the position property.
     * If both $position and $alignment are set, those are used accordingly to position the popup relatively with the
     * sender.
     *
     * @param string $position  Position can be: [top | bottom | left | right].
     *                          If only $position is set as a string, that is used to position the popup in relation
     *                          with the window. Here position can be: [top | bottom | left | right | center | user].
     *                          or a number between 1 and 9 [inclusive] that maps the numeric keyboard numbers to
     *                          places on the screen. Finally, if only the position is set as an array, this is used to
     *                          position the popup in relation with the window ['fixed'] or the parent ['absolute'].
     *                          That array can have the following keys: [top | bottom | left | right | position]
     * @param string $alignment Alignment can be:
     *                          [top | bottom | left | right | center (wherever this makes sense)].
     *
     * @return mixed The position value, or $this.
     */
    public function position($position = '', $alignment = '')
    {
        // Return value
        if (empty($position)) {
            return $this->position;
        }

        // Set value
        if (!empty($alignment)) {
            $this->position = $position . '|' . $alignment;

            return $this;
        }

        if (!is_array($position)) {
            $this->position = $position;

            return $this;
        }

        $info = array_intersect_key($position, ['top' => '', 'bottom' => '', 'left' => '', 'right' => '', 'position' => '']);
        $this->position = $info;

        return $this;
    }

    /**
     * Gets or defines the distance offset property.
     *
     * @param int $offset The distance offset value
     *
     * @return mixed The distance from sender, or $this.
     */
    public function distanceOffset($offset = 0)
    {
        // Return value
        if (empty($offset)) {
            return $this->distanceOffset;
        }

        // Set value
        $this->distanceOffset = $offset;

        return $this;
    }

    /**
     * Gets or defines the alignment offset property.
     *
     * @param int $offset The align offset value
     *
     * @return mixed The alignment with sender, or $this.
     */
    public function alignOffset($offset = 0)
    {
        // Return value
        if (empty($offset)) {
            return $this->alignOffset;
        }

        // Set value
        $this->alignOffset = $offset;

        return $this;
    }

    /**
     * Gets or defines the invertDock property.
     *
     * @param string $orientation The orientation to invert docking.
     *                            Default is 'none'.
     *                            Available invertions are OR_HORIZONTAL, OR_VERTICAL and OR_BOTH.
     *
     * @return mixed The inverDock property, or $this.
     */
    public function invertDock($orientation = '')
    {
        // Return value
        if (empty($orientation)) {
            return $this->invertDock;
        }

        // Set value
        $this->invertDock = $orientation;

        return $this;
    }
}
