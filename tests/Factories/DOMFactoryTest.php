<?php
/**
 * Created by PhpStorm.
 * User: ioannispapikas
 * Date: 16/06/16
 * Time: 16:46
 */

namespace Panda\Ui\Tests\Factories;

use Panda\Ui\Factories\DOMFactory;
use PHPUnit_Framework_TestCase;

// Initialize testing env
include('../init.php');

class DOMFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DOMFactory
     */
    private $DOMFactory;

    public function setUp()
    {
        parent::setUp();

        $this->DOMFactory = new DOMFactory();
    }

    public function testBuildElement()
    {
        $element = $this->DOMFactory->buildElement('item', 'value');
        $this->assertEquals('item', $element->tagName);
        $this->assertEquals('value', $element->nodeValue);
    }
}
