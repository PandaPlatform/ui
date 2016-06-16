<?php

namespace Panda\Ui\Tests\Html;

use Panda\Ui\Html\HTMLDocument;
use PHPUnit_Framework_TestCase;

// Initialize testing env
include('../init.php');

class HTMLDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLDocument
     */
    private $HTMLDocument;

    public function setUp()
    {
        parent::setUp();

        $this->HTMLDocument = new HTMLDocument(null);
    }

    public function testMagic()
    {
        // Test simple div
        $element = $this->HTMLDocument->div($value = 'div_value', $id = 'id', $class = 'class');
        $this->assertEquals('div', $element->tagName);
        $this->assertEquals('div_value', $element->nodeValue);
        $this->assertEquals('id', $element->getAttribute('id'));
        $this->assertEquals('class', $element->getAttribute('class'));

        // Test other elements
        $element = $this->HTMLDocument->p();
        $this->assertEquals('p', $element->tagName);
    }
}
