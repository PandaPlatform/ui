<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Tests;

use Panda\Ui\Html\Factories\HTMLFactory;
use Panda\Ui\Html\Handlers\HTMLHandler;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;
use PHPUnit\Framework\TestCase;

/**
 * Class HTMLElementTest
 * @package Panda\Ui\Html\Tests
 */
class HTMLElementTest extends TestCase
{
    /**
     * @var HTMLElement
     */
    private $container;

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function setUp()
    {
        parent::setUp();

        // Create container
        $this->container = new HTMLElement(new HTMLDocument(new HTMLHandler(), new HTMLFactory()), 'div');

        // Disable errors
        error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED));
    }

    /**
     * @covers \Panda\Ui\Html\HTMLElement::render
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function testRenderBasic()
    {
        // Build tree
        $child = $this->container->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('p');
        $this->container->append($child);

        // Create parameters
        $currentClass = 'test-class';
        $parameters = [
            'p' => [
                'attributes' => [
                    'id' => 'test-paragraph',
                    'class' => $currentClass,
                ],
            ],
        ];

        // Render parameters
        $this->container->render($parameters);

        // Assert parameters
        $child = $this->container->select('p')->item(0);
        foreach ($parameters['p']['attributes'] as $name => $value) {
            $this->assertEquals($value, $child->getAttribute($name));
        }

        // Check for adding class
        $newClass = 'new-class';
        $parameters = [
            'p' => [
                'attributes' => [
                    'class' => sprintf('& %s', $newClass),
                ],
            ],
        ];

        // Render parameters
        $this->container->render($parameters);

        // Assert new class
        $this->assertEquals(sprintf('%s %s', $currentClass, $newClass), $child->getAttribute('class'));

        // Remove class
        $parameters = [
            'p' => [
                'attributes' => [
                    'class' => null,
                ],
            ],
        ];

        // Render parameters
        $this->container->render($parameters);

        // Assert new class
        $this->assertEmpty($child->getAttribute('class'));
    }

    /**
     * @covers \Panda\Ui\Html\HTMLElement::render
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\AssertionFailedError
     * @throws \DOMException
     */
    public function renderSelect()
    {
        // Build tree
        $child = $this->container->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('select');
        $this->container->append($child);

        // Create parameters
        $parameters = [
            'select' => [
                'select' => [
                    'options' => [
                        'n1' => 'v1',
                        'n2' => 'v2',
                        'n3' => 'v3',
                    ],
                    'checked_value' => [
                        'n1',
                        'n2',
                    ],
                ],
            ],
        ];

        // Render parameters
        $this->container->render($parameters);

        // Assert options
        foreach ($parameters['select']['select']['options'] as $name => $value) {
            $this->assertNotEmpty($this->container->select(sprintf('select option[name="%s"][value="%s"]', $name, $value)));
        }

        // Assert checked values
        $this->assertEquals('selected', $this->container->select(sprintf('select option[name="%s"]', 'n1'))->item(0)->getAttribute('selected'));
        $this->assertEquals('selected', $this->container->select(sprintf('select option[name="%s"]', 'n2'))->item(0)->getAttribute('selected'));
    }
}
