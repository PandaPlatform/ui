<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Notifications;

use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Notification
 * Creates a UI notification for all usages.
 * It can be used to notify the user for changes and updates, show warning messages or show succeed messages after a
 * successful post.
 *
 * @package Panda\Ui\Html\Notifications
 *
 * @version 0.1
 */
class Notification extends HTMLElement implements DOMBuilder
{
    /**
     * The error notification type.
     *
     * @var string
     */
    const ERROR = 'error';

    /**
     * The warning notification type.
     *
     * @var string
     */
    const WARNING = 'warning';

    /**
     * The info notification type.
     *
     * @var string
     */
    const INFO = 'info';

    /**
     * The success notification type.
     *
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * The notification's body.
     *
     * @var HTMLElement
     */
    protected $body;

    /**
     * Notification constructor.
     *
     * @param HTMLDocument $HTMLDocument
     */
    public function __construct(HTMLDocument $HTMLDocument)
    {
        parent::__construct($HTMLDocument, $name = 'div', $value = '', $id = '', 'uiNotification');
    }

    /**
     * Builds the notification.
     *
     * @param string $type       The notification's type. Use class constants to define this type.
     *                           It is INFO by default.
     * @param bool   $header     Specified whether the notification will have header or not.
     * @param bool   $timeout    If TRUE, sets the notification to fade out after 1.5 seconds.
     * @param bool   $disposable Lets the user to be able to close the notification.
     *
     * @return $this
     */
    public function build($type = self::INFO, $header = false, $timeout = false, $disposable = false)
    {
        // Normalize type
        $type = (empty($type) ? self::INFO : $type);
        $this->addClass($type);

        // Set timeout class
        if ($timeout) {
            $this->addClass('timeout');
        }

        // Build Header (if any)
        if ($header) {
            $this->buildHead($type, $disposable);
        }

        // Build Body
        return $this->buildBody();
    }

    /**
     * Appends an element to notification body
     *
     * @param HTMLElement $content The element to be appended.
     *
     * @return $this
     */
    public function appendToBody($content)
    {
        // Append a valid element to notification body
        $this->getBody()->append($content);

        // Return notification object
        return $this;
    }

    /**
     * Creates and appends a custom notification message.
     *
     * @param mixed $message The message content (string or HTMLElement)
     *
     * @return $this
     */
    public function appendCustomMessage($message)
    {
        $customMessage = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', $message, '', 'customMessage');

        return $this->append($customMessage);
    }

    /**
     * Builds the notification header.
     *
     * @param HTMLElement|string $title      The header's title.
     * @param bool               $disposable Adds a close button to header and lets the user to be able to close the
     *                                       notification.
     *
     * @return $this
     */
    private function buildHead($title, $disposable = false)
    {
        // Build Head Element
        $head = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', $title, '', 'uiNtfHead');
        $this->append($head);

        // Populate the close button
        if ($disposable) {
            $closeBtn = $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', '', '', 'closeBtn');
            $head->append($closeBtn);
        }

        return $this;
    }

    /**
     * Builds the notification body.
     *
     * @return $this
     */
    private function buildBody()
    {
        // Build Body Element
        $this->body = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'uiNtfBody');
        $this->append($this->body);

        // Populate the notification icon
        $icon = $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', '', '', 'uiNtfIcon');
        $this->appendToBody($icon);

        return $this;
    }

    /**
     * @return HTMLElement
     */
    public function getBody()
    {
        return $this->body;
    }
}
