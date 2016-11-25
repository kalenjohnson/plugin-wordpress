<?php
namespace FatPanda\WordPress\Tests;

use PHPUnit\Framework\TestCase;
use FatPanda\WordPress\Plugin;

class TestPluginCreate extends TestCase {

	function testPluginCreate()
	{
		$created = Plugin::create();

		print_r($created);
	}

}