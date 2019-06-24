CHANGELOG for 3.1.x
===================

This changelog references the relevant changes (bug and security fixes) done in all versions (major and minor)

To get the diff for a specific change, go to https://github.com/PandaPlatform/ui/commit/XXX where XXX is the change hash

* 3.1.13
  * [Html] Fix: Use proper css selector with attribute values
  
* 3.1.12
  * [Html] Fix Compatibility with HTMLElement and DOMElement

* 3.1.11
  * [Html] Remove explicit check for form tag in render form values
  
* 3.1.10
  * [Html] Support multiple checked values for select elements in render()
  
* 3.1.9
  * [Html] Support style attributes in render()

* 3.1.8
  * [Html] Remove character '&' replace functionality from $data['data'] in renderElement

* 3.1.7
  * [Html] HTMLElement::render(): Check for innerHTML() value properly
  * [Html] HTMLElement::render(): Re-order functionality to align
  
* 3.1.6
  * [Html] HTMLElement::render(): Support '&' only for class attributes
  
* 3.1.5
  * [Dom] Add value check for string '0'
  
* 3.1.4
  * [Html] HTMLElement::render(): Support multiple elements by selector.
  * [Html] HTMLElement::render(): Support more actions like append and prepend.
  * [Html] HTMLElement::render(): Support extra attributes for nodeValue and innerHTML.
  
* 3.1.3
  * [Html] Render HTMLElement with a set of given parameters including attributes etc.
  
* 3.1.2
  * Accept attributes when building Dom and Html elements
  
* 3.1.1
  * Update PHPUnit to ~6.3
