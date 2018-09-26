<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Helpers;

use DOMElement;
use Panda\Ui\Html\Handlers\HTMLHandlerInterface;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\CssSelector\Exception\SyntaxErrorException;

/**
 * Class FormHelper
 * @package Panda\Ui\Html\Helpers
 */
class FormHelper
{
    /**
     * @param HTMLHandlerInterface $handler
     * @param DOMElement           $container
     * @param array                $values
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public static function setValues(HTMLHandlerInterface $handler, DOMElement $container, $values = [])
    {
        foreach ($values as $name => $value) {
            // Normal inputs
            $types = ['text', 'number', 'email', 'hidden', 'password'];
            foreach ($types as $type) {
                $input = self::getElementBySelector($handler, $container, sprintf('input[type="%s"][name="%s"]', $type, $name));
                if (!empty($input)) {
                    $handler->attr($input, 'value', $value);
                }
            }

            // Checkbox
            $types = ['checkbox'];
            foreach ($types as $type) {
                $input = self::getElementBySelector($handler, $container, sprintf('input[type="%s"][name="%s"]', $type, $name));
                if (!empty($input)) {
                    $handler->attr($input, 'checked', $value);
                }
            }

            // Radio
            $types = ['radio'];
            foreach ($types as $type) {
                $input = self::getElementBySelector($handler, $container, sprintf('input[type="%s"][name="%s"][value="%s"]', $type, $name, $value));
                if (!empty($input)) {
                    $handler->attr($input, 'checked', $value);
                }
            }

            // Options in select
            $option = self::getElementBySelector($handler, $container, sprintf('select[name="%s"] option[value="%s"]', $name, $value));
            if (!empty($option)) {
                $handler->attr($option, 'selected', true);
            }

            // Textareas
            $textarea = self::getElementBySelector($handler, $container, sprintf('textarea[name="%s"]', $name, $value));
            if (!empty($textarea)) {
                $handler->innerHTML($textarea, $value);
            }
        }
    }

    /**
     * @param HTMLHandlerInterface $handler
     * @param DOMElement           $container
     * @param string               $selector
     *
     * @return DOMElement|null
     * @throws \InvalidArgumentException
     */
    private static function getElementBySelector(HTMLHandlerInterface $handler, DOMElement $container, $selector)
    {
        try {
            return $handler->select($container->ownerDocument, $selector, $container)->item(0);
        } catch (SyntaxErrorException $ex) {
            // Do nothing
        } catch (InternalErrorException $ex) {
            // Do nothing
        }

        return null;
    }
}
