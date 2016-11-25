# CHANGELOG

## 1.0.3
* Add concept of a "workbench"—a scratch space for putting generated files—to support TestCase development
* Do a better job of divorcing the scaffolding and the created plugins, e.g., make a dedicated composer.json file
* After creating a plugin, delete the TestPluginCreate test case, since it's part of scaffolding testing, not part of testing the generated plugin

## 1.0.2
* Debugging Plugin::create; I assume Composer was bootstrapped for Composer events, but it does not appear to be

## 1.0.1
* Still debugging; pushing to test packagist installation