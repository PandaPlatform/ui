<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Tests\Html;

use DOMElement;
use Panda\Ui\Factories\HTMLFactory;
use Panda\Ui\Handlers\HTMLHandler;
use Panda\Ui\Html\HTMLDocument;
use PHPUnit_Framework_TestCase;

// Initialize testing env
include '../init.php';

class HTMLDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLDocument
     */
    private $HTMLDocument;

    public function setUp()
    {
        parent::setUp();

        $this->HTMLDocument = new HTMLDocument(new HTMLHandler(), new HTMLFactory());
    }

    public function testMagic()
    {
        // Test simple div
        /** @var DOMElement $element */
        $element = $this->HTMLDocument->div($value = 'div_value', $id = 'id', $class = 'class');
        $this->assertEquals('div', $element->tagName);
        $this->assertEquals('div_value', $element->nodeValue);
        $this->assertEquals('id', $element->getAttribute('id'));
        $this->assertEquals('class', $element->getAttribute('class'));

        // Test other elements
        /** @var DOMElement $element */
        $element = $this->HTMLDocument->p();
        $this->assertEquals('p', $element->tagName);
    }
}
