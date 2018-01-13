# Dom Package

> **Note:** [READ-ONLY] Subtree split of the Panda Ui Package

The Dom Package allows you to easily manipulate DOM Elements.

[![Latest Stable Version](https://poser.pugx.org/panda/dom/v/stable?format=flat-square)](https://packagist.org/packages/panda/dom)
[![Total Downloads](https://poser.pugx.org/panda/dom/downloads?format=flat-square)](https://packagist.org/packages/panda/dom)
[![License](https://poser.pugx.org/panda/dom/license?format=flat-square)](https://packagist.org/packages/panda/dom)

- [Introduction](#introduction)
- [Installation](#installation)
  - [Through the composer](#through-the-composer)
- [DOM](#dom)
  - [DOM Handlers](#dom-handlers)
  - [DOM Factories](#dom-factories)
  - [Extending DOM](#extending-dom)

## Introduction
Panda Ui DOM component is a backend ui handler/renderer engine that enables generating including xml content in a more structured way.

This component is extending the normal DOM structure that is offered by the language itself, including some of the following classes:
- [`DOMNode`](http://php.net/manual/en/class.domnode.php)
- [`DOMDocument`](http://php.net/manual/en/class.domdocument.php)
- [`DOMElement`](http://php.net/manual/en/class.domelement.php)

This is the main reason why this component is so powerful, providing extra, faster and more clever functionality using existing components.

This package is able to create html pages using the DOM structure fast and easy. Some of the features include:

* Dom manipulation from PHP
* Dom Factory that creates Dom Elements

## Installation

### Through the composer

Add the following line to your `composer.json` file:

```
"panda/dom": "^3.1"
```

## DOM

### DOM Handlers

We built Ui component with the ability to be extensible and configurable.
For this reason we have inserted handlers and factories which can be replaced, just by using the interfaces provided.

In order to be able to manipulate DOM elements in any way, including elements that we create but also elements that we can retrieve from a Document (using xpath), we had to create an independent structure of handlers that can manipulate DOM without actually being part of it.

Building a DOM tree can be a painful process using only native functions, that's why we created DOMHandler, to replace a multi-line functionality with a single-line function call.

`DOMHandler` is responsible for applying simple DOM manipulations to xml documents, generic enough for all the document types. Let's see some examples here:

Adding an attribute:

```php
use Panda\Ui\Dom\Handlers\DOMHandler;

// Normal DOMElement way
// The same way for get and remove
// Where $element is a DOMElement object
$element->setAttribute($name = 'id', $value = 'id_value');


// Using DOMHandler
$handler = new DOMHandler();

// Set an attribute
$handler->attr($element, $name = 'id', $value = 'id_value', $validate = false);

// Get an attribute
$handler->attr($element, $name = 'id');

// Remove an attribute
$handler->attr($element, $name = 'id', $value = null);
```

The previous example might not say much, but moving on to more functionality, we have the following functions available:
* `attr(DOMElement &$element, $name, $value = '', $validate = false);`
* `attrs(DOMElement &$element, $value = []);`
* `appendAttr(DOMElement &$element, $name, $value);`
* `data(DOMElement &$element, $name, $value = []);`
* `nodeValue(DOMElement &$element, $value = null);`
* `append(DOMElement &$parent, &$child);`
* `prepend(DOMElement &$parent, &$child);`
* `remove(DOMElement &$element);`
* `replace(DOMElement &$old, &$new);`
* `evaluate(DOMDocument $document, $query, $context = null);`

### DOM Factories

After describing the structure with DOMPrototype and DOMItem, we are here to introduce the DOM Factories.
DOM Factories are used to create DOM items with simple calls without the need to create extra objects like the DOMDocument or the DOMHandler.
These factories are not replacing the functionality of a container, but they just provide an interface for creating all the elements needed from a single class.

The DOM Factory class is the smallest form of factory which provides one public function for building a simple DOMElement, the buildElement() function. The DOM Factory expects a DOMPrototype to be set with the setDOMDocument() function so that it can create all the elements needed.

Mainly the factories are accessible through the DOMPrototype, where we provide it as a dependency in the constructor. The Document is responsible for initializing the factory and connecting it to the current document.

```php
use Panda\Ui\Dom\Handlers\DOMHandler;
use \Panda\Ui\Dom\Factories\DOMFactory;
use \Panda\Ui\Dom\DOMPrototype;

// Create a handler instance
$handler = new DOMHandler();

// Create a new factory instance
$factory = new DOMFactory();

// Create a document and provide the handler and factory
$document = new DOMPrototype($handler, $factory);


// Get the factory and build an element
$document->getDOMFactory()->buildElement($name = 'div', $value = 'value');

// Document uses the above function with a 'facade' function called create:
$document->create($name = 'div', $value = 'value');
```

### Extending DOM

Two are the base classes of the entire component, which extend php objects:

DOMItem:
```php
class DOMItem extends DOMElement
{
}
```

DOMPrototype:
```php
class DOMPrototype extends DOMDocument
{
}
```

Both of the objects are using two basic interfaces for handling the entire functionality and are standing there like observers for the building.
Those are the `DOMHandler` and `DOMFactory` interfaces.

#### DOMPrototype

The DOMPrototype object is the base object for XML Documents (and HTML Documents). It provides some basic functionality and the rest is being handled by a DOMHandler and a DOMFactory.

The DOMPrototype object has the following functionalities:
* `create($name = 'div', $value = '')`
* `append($element);`
* `evaluate($query, $context = null);`
* `find($id, $nodeName = '*');`
* `getXML($format = false);`

The above functions support the basic Document object. However you can perform more tasks using the DOMHandler and create more elements using the DOMFactory object.

```php
use Panda\Ui\Dom\Handlers\DOMHandler;
use \Panda\Ui\Dom\Factories\DOMFactory;
use \Panda\Ui\Dom\DOMPrototype;

// Create the document
// Using a container here would make the call a lot easier
$DOMHandler = new DOMHandler();
$DOMFactory = new DOMFactory();
$document = new DOMPrototype($DOMHandler, $DOMFactory);

// Create the root element and append it to the document
$root = $document->create($name = 'root', $value = '');
$document->append($root);

// Create an element and append it to the root
$element = $document->create($name = 'child', $value = 'This is a root child.');
$root->append($element);
```

#### DOMItem

The basic root element for creating DOM elements is the DOMItem basic object. DOMItem extends the given php functionality of a DOMElement and provides a better way to manipulate the item writing less code. The object supports the following functionality:
* `attr($name, $value = '', $validate = false);`
* `attrs($value = []);`
* `appendAttr($name, $value);`
* `nodeValue($value = null);`
* `append(&$element);`
* `appendTo(&$element);`
* `prepend(&$element);`
* `prependTo(&$element);`
* `remove();`
* `replace($element);`

The DOMItem constructor accepts a DOMPrototype (document) so that it can be associated with it and it can be handled by a client (otherwise it will be a read-only object). The Document itself requires a DOMHandler. The DOMItem uses this DOMHandler to manipulate itself using all the previous functions. Basically all these functions are being handled by the DOMHandler and not the DOMItem itself.

```php
use \Panda\Ui\Dom\DOMPrototype;
use \Panda\Ui\Dom\DOMItem;

// Create the document to associate the DOMItem with
$document = new DOMPrototype(new DOMHandler(), new DOMFactory());

// Create the item
$item = new DOMItem($document, $name = 'div', $value = '');

// Update the item
$item->attr('name', 'item_name');
$item->attr('title', 'item_title');

// Append item to document
$document->append($item);
```

> Every DOMItem that is being created is being appended to the given document so that we can edit it.
