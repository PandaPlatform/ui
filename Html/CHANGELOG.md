CHANGELOG
===================

* 3.2.7
  * Fix: Render values that look empty for select options

* 3.2.2
  * Fix: Use HTMLElement as default context when rendering
  
* 3.2.1
  * Create Render logic with interfaces and collections
  * Add RenderCollectionInterface dependency in HTMLDocument
  * Use HTMLDocument render instead of HTMLElement render 

* 3.1.10 (2019-01-30)
  * Support multiple checked values for select elements in render()
  
* 3.1.9 (2019-01-07)
  * Support style attributes in render()

* 3.1.8 (2018-11-08)
  * Remove character '&' replace functionality from $data['data'] in renderElement

* 3.1.7 (2018-10-18)
  * HTMLElement::render(): Check for innerHTML() value properly
  * HTMLElement::render(): Re-order functionality to align

* 3.1.6 (2018-10-17)
  * HTMLElement::render(): Support '&' only for class attributes
  
* 3.1.4 (2018-10-01)
  * HTMLElement::render(): Support multiple elements by selector.
  * HTMLElement::render(): Support more actions like append and prepend.
  * HTMLElement::render(): Support extra attributes for nodeValue and innerHTML.
  
* 3.1.3 (2018-09-26)
  * Render HTMLElement with a set of given parameters including attributes etc.
  
* 3.1.2 (2018-09-04)
  * Accept attributes when building Html elements
  
* 3.1.1 (2018-01-13)
  * Update PHPUnit to ~6.3
