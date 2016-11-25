<?php
namespace FatPanda\WordPress\Tests;

use PHPUnit\Framework\TestCase;
use FatPanda\WordPress\Plugin;
use FatPanda\WordPress\PluginWorkbench;

class TestPluginCreate extends TestCase {

	protected $workbench;

	function setUp()
	{
		$this->workbench = new PluginWorkbench();
		$this->workbench->reset();
		$this->workbench->makeDirectory('src');
	}

	function testPluginCreate()
	{
		$created = Plugin::create( null, PluginWorkbench::getFilePath() );

		$this->assertTrue(file_exists($created['files']['main']));
		$this->assertTrue(file_exists($created['files']['plugin']));
		$this->assertTrue(file_exists($created['files']['composer']));
		$this->assertNotFalse(json_encode(file_get_contents($created['files']['composer'])));
	}

}