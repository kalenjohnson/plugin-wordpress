# Write WordPress plugins, our way.

At [Fat Panda](https://wordpress.withfatpanda.com), sometimes we build plugins for WordPress. To speed up our prototyping process and time to market, we've created this project and process, and now you can use it too.

![alt text](https://github.com/withfatpanda/plugin-wordpress/raw/master/lib/common/images/demo.gif "Creating a new Plugin project")

## This ain't the WordPress way.

WordPress is amazing. So are [Composer](https://getcomposer.org/) and [Packagist](https://packagist.org/). They're great for different reasons. 

WordPress is great because it's an amazing content management system built-up by a community of tens of thousands of developers working to make it so. Composer and Packagist are great because they've organized the world of PHP into discreet, reusable components.

What do we want? To be able to combine the best of these two worlds, and maintain as much of the portability of both as possible. 

The result is better software and more effficient production. The [Roots](https://roots.io/) project has proven this to be true; so let's build WordPress plugins that dependend on the same great libraries that all the other PHP developers are depending on. 

Let's stop reinventing the wheel. :heart: 

From this point forward, let our WordPress plugins depend on the best Composer has to offer, and let them all be packages that can be published through and installed from Packagist.

## Getting Started

1. Setup a [Workbench](https://github.com/withfatpanda/workbench-wordpress). A Workbench is an installation of WordPress that you'll use to build and test your plugins&mdash;it's based on [Bedrock](https://roots.io/bedrock).

2. Install [Studio](https://github.com/franzliedke/studio). Studio is a utility that allows you to author your Composer packages in context (as if they were already dependencies in another project):

	`composer global require franzl/studio`

3. Create a new plugin project anywhere in your local filesystem: `composer create-project withfatpanda/plugin-wordpress /path/to/my-plugin`

	A command-line wizard will walk you through creating your project scaffolding.

	**Note:** Your plugin will include [withfatpanda/illuminate-wordpress](https://github.com/withfatpanda/illuminate-wordpress) as a dependency&mdash;it's free, and awesome.

4. Switch back to your Workbench path, and use studio to import the plugin into your Workbench:

  `studio load /path/to/my-plugin && composer require my-namespace/my-plugin:* && composer update`

