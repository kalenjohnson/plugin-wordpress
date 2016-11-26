# Write WordPress plugins, our way.

At [Fat Panda](https://wordpress.withfatpanda.com), sometimes we build plugins for WordPress. To speed up our prototyping process and time to market, we've created this project and process, and now you can use it too.

![alt text](https://github.com/withfatpanda/plugin-wordpress/raw/master/lib/common/images/demo.gif "Creating a new Plugin project")

## This ain't the WordPress way.

WordPress is amazing. So are [Composer](https://getcomposer.org/) and [Packagist](https://packagist.org/). They're great for different reasons. 

WordPress is great because it's an amazing content management system built-up by a community of tens of thousands of developers working to make it so. Composer and Packagist are great because they've organized the world of PHP into discreet, reusable components.

What do we want? To be able to combine the best of these two worlds, and maintain as much of the portability of both as possible. 

The result is better software and more effficient production. The [Roots](https://roots.io/) project has proven this to be true; so let's follow suit, and start building WordPress plugins that depend on the same great libraries that all the other PHP developers are depending on. 

From this day forward, let our WordPress plugins depend on the best Composer has to offer, and let them all be packages that can be published through and installed from Packagist. Let's stop reinventing the wheel, and start shipping faster. :rocket: :heart: 

## Before You get Started

### This ain't the WordPress way.

This bears repeating from above: creating WordPress plugins with third-party dependencies isn't new; using Composer to manage those dependencies still is (relatively speaking). We're confident that once you adjust to the automation of dependency management, you'll never be able to go back&mdash;that's how it was for us, anyway.

### Bedrock isn't your typical WordPress codebase.

The [Bedrock](https://roots.io/bedrock) codebase exists to make building with WordPress more like working with an application stack and less like, well, working in WordPress. 

In Bedrock, as much as can be moved to configuration has been&mdash;you don't, for example, touch the guts of the **wp-config.php** file, opting instead to manage configuration in a [plain-text environment file](https://roots.io/bedrock/docs/environment-variables/); the codebase is designed to load everything as dependencies managed by Composer, including WordPress' core.

At first, the file tree is going to look a little weird:

![alt text](https://github.com/withfatpanda/plugin-wordpress/raw/master/lib/common/images/project-files.png "Wait... where's all my stuff?")

### Dude, where's my plugin?

When you build and install plugins using this approach, a special Composer installer puts them right where they need to be: in the **app/plugins** folder in your Bedrock project. For those familiar with either Composer or WordPress, this will make no sense (at first)&mdash;WordPress folks expect plugins to be in a folder named **wp-content/plugins** and Composer users expect packages to be installed into a **./vendors** folder in the root of the project.

This is better. Unfortunately, you'll just have to trust us until you dig in.

## Starting a New Plugin Project

1. Setup a [Workbench](https://github.com/withfatpanda/workbench-wordpress). A Workbench is an installation of WordPress that you'll use to build and test your plugins&mdash;it's based on [Bedrock](https://roots.io/bedrock).

2. Install [Studio](https://github.com/franzliedke/studio). Studio is a utility that allows you to author your Composer packages in context (as if they were already dependencies in another project):

	`composer global require franzl/studio`

3. Create a new plugin project anywhere in your local filesystem: `composer create-project withfatpanda/plugin-wordpress /path/to/my-plugin`

	A command-line wizard will walk you through creating your project scaffolding.

	**Note:** Your plugin will include [withfatpanda/illuminate-wordpress](https://github.com/withfatpanda/illuminate-wordpress) as a dependency&mdash;it's free, and awesome.

4. Switch back to your Workbench path, and use studio to import the plugin into your Workbench:

  `studio load /path/to/my-plugin && composer require my-namespace/my-plugin:* && composer update`

