CHANGELOG for 3.2.x
===================

This changelog references the relevant changes (bug and security fixes) done in all versions (major and minor)

To get the diff for a specific change, go to https://github.com/PandaPlatform/ui/commit/XXX where XXX is the change hash

* 3.2.7
  * [Dom] Fix: Remove any html from select options titles to prevent html tag display

* 3.2.6
  * [Dom] Revert use of innerHTML as it causes security issues with JavaScript injection
  
* 3.2.5
  * [Dom] Fix: Use innerHTML to display select option titles with html
  
* 3.2.4
  * [Html] Create AbstractRender to simplify code and eliminate duplicates
  * [Html] Remove selected options from select elements when setting new values
  
* 3.2.3
  * [Html] Fix: Use proper css selector with attribute values
  
* 3.2.2
  * [Html] Fix: Use HTMLElement as default context when rendering
  
* 3.2.1
  * [Html] Create Render logic with interfaces and collections
  * [Html] Add RenderCollectionInterface dependency in HTMLDocument
  * [Html] Use HTMLDocument render instead of HTMLElement render 
