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

namespace Panda\Ui\Html\Templates\Forms;

use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Html\HTMLElement;

/**
 * Simple Form Template builder
 *
 * Builds an html form with a specific layout, if the user wants to.
 * It has access to the FormFactory (it extends it) and can build every form control.
 *
 * @package Panda\Ui\Html\Templates\Forms
 *
 * @version 0.1
 */
class SimpleForm extends Form implements DOMBuilder
{
    /**
     * The form's control button container.
     *
     * @var HTMLElement
     */
    protected $formControls;

    /**
     * Builds the form.
     *
     * @param string $id             The form id.
     * @param string $action         The form action url string.
     * @param bool   $async          Sets the async attribute for simple forms.
     * @param bool   $fileUpload     This marks the form ready for file upload. It adds the enctype attribute where no
     *                               characters are encoded. This value is required when you are using forms that have a
     *                               file upload control.
     * @param bool   $defaultButtons Options whether the form will have the default control buttons (execute and reset
     *                               buttons). It is TRUE by default.
     * @param bool   $requiredNotes  Whether the form has required visual input fields.
     *
     * @return $this
     */
    public function build($id = '', $action = '', $async = true, $fileUpload = false, $defaultButtons = true, $requiredNotes = false)
    {
        // Build form template
        parent::build($id, $action, $async, $fileUpload);

        // Add extra template attributes
        $this->addClass('form-simple');

        // Build simple form
        if ($requiredNotes) {
            $this->buildRequiredNotes();
        }

        // Build form controls
        $this->buildControls($defaultButtons);

        return $this;
    }

    /**
     * Build the required notes container.
     *
     * @return $this
     */
    private function buildRequiredNotes()
    {
        // Build the required notes container
        $requireNotesContainer = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'form-simple-required-notes');

        // Create note
        $note = $this->getHTMLDocument()->getHTMLFactory()->buildElement('p', '', '', 'rqNote');
        $requireNotesContainer->append($note);

        $star = $this->requiredStar();
        $note->append($star);
        $title = $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', 'All fields marked with asterisk are required.');
        $note->append($title);

        // Append before controls
        $this->append($requireNotesContainer);

        return $this;
    }

    /**
     * Builds and appends the form default controls (submit and reset buttons).
     *
     * @param bool $defaultButtons Options whether the form will have the default control buttons (execute and reset
     *                             buttons).
     */
    private function buildControls($defaultButtons)
    {
        // Create form controls
        $this->formControls = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'form-controls');
        $this->append($this->formControls);

        // Insert Default buttons for save and reset
        if ($defaultButtons) {
            $row = $this->formRow();
            $this->formControls->append($row);

            // Submit button
            $submitBtn = $this->getHTMLFormFactory()->buildSubmitButton('Save', '', '', 'positive');
            $row->append($submitBtn);

            // Reset button
            $resetBtn = $this->getHTMLFormFactory()->buildResetButton('Cancel', '', '');
            $row->append($resetBtn);
        }
    }

    /**
     * Builds a form row including a label and an input.
     *
     * @param string      $title
     * @param HTMLElement $input
     * @param bool        $required
     * @param string      $notes
     *
     * @return HTMLElement
     */
    public function buildRow($title, $input, $required = false, $notes = '')
    {
        // Create form row
        $row = $this->formRow();

        // Create label
        $inputId = $input->attr('id');
        $label = $this->buildLabel($title, $inputId, $required);
        $row->append($label);

        // Append input
        if (!is_null($input)) {
            $input->addClass('form-input');
            $row->append($input);
        }

        // Set input notes
        if (!empty($notes)) {
            $notesElement = $this->formNotes($notes);
            $row->append($notesElement);
        }

        return $row;
    }

    /**
     * Builds and returns a simple form label.
     *
     * @param string $title
     * @param string $for
     * @param bool   $required
     *
     * @return HTMLElement
     */
    private function buildLabel($title, $for, $required = false)
    {
        // Create label
        $label = $this->formLabel($title, $for);

        // Set Required indicator
        if ($required) {
            $label->append($this->requiredStar());
        }

        $colonSpan = $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', ':');
        $label->append($colonSpan);

        return $label;
    }

    /**
     * Builds and inserts a form row including a label and an input.
     *
     * @param string      $title
     * @param HTMLElement $input
     * @param bool        $required
     * @param string      $notes
     *
     * @return $this
     */
    public function appendRow($title, $input, $required = false, $notes = '')
    {
        // Build the row and append it to the form
        return $this->appendToBody($this->buildRow($title, $input, $required, $notes));
    }

    /**
     * Append a form control (button) to the form's control button container.
     *
     * @param HTMLElement $element
     *
     * @return $this
     */
    public function appendToControls($element)
    {
        $this->formControls->append($element);

        return $this;
    }

    /**
     * Creates and returns a form row.
     *
     * @return HTMLElement
     */
    public function formRow()
    {
        return $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'form-simple-row');
    }

    /**
     * Get a form-simple label.
     *
     * @param mixed  $content
     * @param string $for
     *
     * @return HTMLElement
     */
    public function formLabel($content, $for)
    {
        return $this->getHTMLFormFactory()->buildLabel($content, $for, $class = 'form-simple-label');
    }

    /**
     * Builds and returns a note container with context.
     *
     * @param string $notes
     *
     * @return HTMLElement
     */
    private function formNotes($notes)
    {
        return $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', $notes, '', 'form-simple-notes');
    }

    /**
     * Build a span with a required star.
     *
     * @return HTMLElement
     */
    private function requiredStar()
    {
        return $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', '*', '', 'required');
    }
}

