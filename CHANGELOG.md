# CHANGELOG

## v1.0.9
* Fix bug in main.stub

## v1.0.8
* Added stubs for examples of CustomPostType and CustomTaxonomy subclasses
* Added more codedoc to the Plugin stub
* Improved documenation

## v1.0.7
* Bugfix: run your test plan first, dummy
* Fix bugs in the test plan, too

## v1.0.6
* Bugfix: was calling the wrong function in PluginWorkbench

## v1.0.5
* Refactor Plugin baseclass into withfatpanda/illuminate-wordpress
* Update documentation

## v1.0.4
* Fixing a bug in Plugin::create
* Removed errant type from composer file

## v1.0.3
* Add concept of a "workbench"—a scratch space for putting generated files—to support TestCase development
* Do a better job of divorcing the scaffolding and the created plugins, e.g., make a dedicated composer.json file
* After creating a plugin, delete the TestPluginCreate test case, since it's part of scaffolding testing, not part of testing the generated plugin

## v1.0.2
* Debugging Plugin::create; I assume Composer was bootstrapped for Composer events, but it does not appear to be

## v1.0.1
* Still debugging; pushing to test packagist installation