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

namespace Panda\Ui\Controls;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use LogicException;
use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\DOMPrototype;
use Panda\Ui\Factories\FormFactory;
use Panda\Ui\Html\HTMLElement;

/**
 * Class DataTable
 * The DataΤαβλε can be used to present multiple data in the form of a grid.
 *
 * If you would like to use the javascript interface for adding, removing and selecting rows, identify each column
 * (including ratios, headers and every row) with a key identifier. However, the sequence of elements must be the same.
 *
 * @package Panda\Ui\Controls
 * @version 0.1
 */
class DataTable extends HTMLElement implements DOMBuilder
{
    /**
     * Object's root list element
     *
     * @type HTMLElement
     */
    private $gridList;

    /**
     * Horizontal capacity
     *
     * @type int
     */
    private $hSize = 0;

    /**
     * If set to TRUE a checkbox will be prepended in each row
     *
     * @type bool
     */
    private $checkable = false;

    /**
     * A list of the row checkboxes
     *
     * @type    array
     */
    private $checkList;

    /**
     * Requested width ratios for the columns
     *
     * @type    array
     */
    private $columnRatios;

    /**
     * DataTable constructor.
     *
     * @param DOMPrototype $HTMLDocument
     * @param string       $id
     * @param string       $class
     */
    public function __construct(DOMPrototype $HTMLDocument, $id = "", $class = "")
    {
        $id = $id ?: "dt" . mt_rand();
        parent::__construct($HTMLDocument, $name = "div", $value = "", $id, $class = "uiDataTable initialize");
    }

    /**
     * Build the datatable.
     *
     * @param bool $checkable  If set to TRUE, the dataGridList will have a checkbox at the start of each row.
     *                         It is FALSE by default.
     * @param bool $withBorder Defines whether the gridList will have visual border.
     *                         It is TRUE by default.
     *
     * @return $this
     */
    public function build($checkable = false, $withBorder = true)
    {
        // Set object variables
        $this->checkable = (!$checkable ? false : true);
        $this->checkList = (!$checkable ? null : array());

        // Add extra classes
        if ($this->checkable) {
            $this->addClass("checkable");
        }
        if ($withBorder) {
            $this->addClass("dgl_wb");
        }

        // Create grid list
        $this->gridList = $this->getHTMLDocument()->create("ul", "", "", "DataTableList");
        $this->append($this->gridList);

        return $this;
    }

    /**
     * Sets the ratios of the columns widths.
     *
     * @param array $ratios The columns width ratios. Must contain numeric values between 0 and 1 (excluding) or else
     *                      the requested ratios will be ignored.
     *
     * @return $this
     */
    public function setColumnRatios($ratios)
    {
        // Filter all values > 0
        $r = array_filter($ratios, function ($val) {
            return $val > 0;
        });

        // Check if all values are valid
        if (count($r) != count($ratios)) {
            return $this;
        }

        // Map all values to percent
        $r = array_map(function ($val) {
            return intval($val * 100);
        }, $r);

        // Check if sums up to 100
        $total = array_sum($r);
        if ($total != 100) {
            throw new InvalidArgumentException("The column ratios don't sum up to 100.");
        }

        // Correct ratio for checkable grid lists
        $totalRatio = (!$this->checkable ? 1.0 : 0.92);
        $r = array_map(function ($val) use ($totalRatio) {
            return $val * $totalRatio;
        }, $r);

        // Set column ratios data to element
        $this->columnRatios = $r;
        $this->gridList->data("column-ratios", $this->columnRatios);

        return $this;
    }

    /**
     * Creates headers in the dataGridList
     *
     * @param array $headers An array with the header contents (can be text or DOMElement)
     */
    public function setHeaders($headers)
    {
        // Set horizontal size of element
        $this->hSize = count($headers);
        $this->data("grid-size", $this->hSize);

        // Add headers
        $gridHeader = $this->appendSimpleRow($headers, "DataTableHeader", $header = true);

        // Add checkable headers
        if ($this->checkable) {
            $this->appendCheckRow($gridHeader, null, false);
        }

        // Create new grid content wrapper
        $gridListContentWrapper = $this->getHTMLDocument()->create("div", "", "", "DataTableContentWrapper");
        $this->gridList->append($gridListContentWrapper);
        $this->gridList = $gridListContentWrapper;
    }

    /**
     * Creates a grid row with the specified contents.
     * If no arguments are passed, the returned value is FALSE.
     * If more than three arguments are passed, those are ignored.
     *
     * @param array  $contents   Array with text or DOMElements
     * @param string $checkName  The name of the row's checkbox (This is ignored if list is not checkable).
     * @param bool   $checked    If list is checkable initializes the row's checkbox in $checked state
     * @param string $checkValue The value of the row's checkbox (This is ignored if list is not checkable).
     *                           It is empty by default.
     *
     * @return $this
     */
    public function appendRow($contents = array(), $checkName = null, $checked = false, $checkValue = "")
    {
        // Insert row contents
        $gridRow = $this->appendSimpleRow($contents, "");

        // Insert row checks
        if ($this->checkable) {
            return $this->appendCheckRow($gridRow, $checkName, $checked, $checkValue);
        }

        return $this;
    }

    /**
     * Assistant function in inserting a row into the dataGridList
     *
     * @param array  $contents Array with text or DOMElements
     * @param string $class    Extra classes for styling specific rows (used for header)
     * @param bool   $header   Whether this row is the header of the list.
     *
     * @return HTMLElement The row inserted.
     * @throws LogicException
     */
    private function appendSimpleRow($contents, $class = "", $header = false)
    {
        // Check width size
        if ($this->hSize == 0) {
            throw new LogicException("There are no headers set on the datatable yet.");
        }

        // Create grid row object
        $gridRow = $this->getHTMLDocument()->create("li", "", "", ($class == "" ? "DataTableRow" : $class));

        // Trim contents to the column size
        if ($this->hSize < count($contents)) {
            array_slice($contents, $this->hSize);
        }

        // Add extra columns
        $contentsCount = count($contents);
        for ($i = 0; $i < $this->hSize - $contentsCount; $i++) {
            $contents[] = $this->getHTMLDocument()->create("span");
        }

        // Insert contents to row
        foreach ($contents as $key => $contentValue) {
            // Create grid text wrapper
            $gridTextWrapper = $this->getHTMLDocument()->create("span", "".$contentValue, "", "DataTableTextWrapper");

            // Create item identifier
            $itemIdentifier = "";
            if (gettype($key) == "string") {
                $itemIdentifier = strtolower(str_replace(" ", "", $key));
            } else if (gettype($contentValue) == "string" || gettype($contentValue) == "integer" || gettype($contentValue) == "double") {
                $itemIdentifier = strtolower(str_replace(" ", "", $contentValue));
            } else if ($contentValue->tagName == "span") {
                $itemIdentifier = strtolower(str_replace(" ", "", $contentValue->getElement()->nodeValue));
            }

            // Set item style
            $gridTextWrapper->appendAttr("style", "max-width:100%;width:100%;box-sizing:border-box;");

            // Create grid cell with given text
            $gridCell = $this->getHTMLDocument()->create("div", $gridTextWrapper, "", "DataTableCell");
            $gridRow->append($gridCell);

            // Set header (if any)
            if ($header && !empty($itemIdentifier)) {
                // Set identifier
                $gridCell->data("column-name", $itemIdentifier);

                // Add sorting icon
                $sortingIcon = $this->getHTMLDocument()->create("div", "", "", "sortingIcon");
                $gridTextWrapper->append($sortingIcon);
            }

            // Set grid item width
            if (empty($this->columnRatios)) {
                $ratio = (!$this->checkable ? 100 : 100 - 8);
                $w = $ratio / $this->hSize;
            } else
                $w = $this->columnRatios[$key];
            $gridCell->attr("style", "width:" . $w . "%;");
        }

        // Append grid row to grid list and return the DOMElement
        $this->gridList->append($gridRow);

        return $gridRow;
    }

    /**
     * Assistant function in prepending a checkbox in a row.
     *
     * @param HTMLElement $row        Row to insert checkbox
     * @param string      $checkName  Name of the checkbox
     * @param bool        $checked    Initial state of the checkbox
     * @param string      $checkValue The value of the row's checkbox (This is ignored if list is not checkable).
     *                                It is empty by default.
     *
     * @return $this
     */
    private function appendCheckRow($row, $checkName, $checked, $checkValue = "")
    {
        // Create the ckeck item
        $gridCheck = $this->getHTMLDocument()->create("div", "", "", "DataTableCheck");

        // Get the checkbox
        $formFactory = new FormFactory($this->getHTMLDocument());
        $chk = $formFactory->buildInput($type = "checkbox", $name = $checkName, $value = $checkValue, $id = "", $class = "", $autofocus = false, $required = false);
        if ($checked) {
            $chk->attr("checked", "checked");
        }
        $gridCheck->append($chk);

        // Add to checklist
        $this->checkList[] = $chk;
        $row->prepend($gridCheck);

        return $this;
    }
}
?>