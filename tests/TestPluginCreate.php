<?php
namespace FatPanda\WordPress\Tests;

use PHPUnit\Framework\TestCase;
use FatPanda\WordPress\PluginWorkbench;

class TestPluginCreate extends TestCase {

	protected $workbench;

	function setUp()
	{
		$this->workbench = new PluginWorkbench();
		$this->workbench->reset();
		$this->workbench->makeDirectory('src');
		$this->workbench->makeDirectory('src/Models');
	}

	function testPluginCreate()
	{
		$created = PluginWorkbench::createPlugin( null, PluginWorkbench::getFilePath() );

		$this->assertTrue(file_exists($created['files']['main']));
		$this->assertTrue(file_exists($created['files']['plugin']));
		$this->assertTrue(file_exists($created['files']['composer']));
		$this->assertTrue(file_exists($created['files']['person']));
		$this->assertTrue(file_exists($created['files']['department']));
		$this->assertNotFalse(json_encode(file_get_contents($created['files']['composer'])));
	}

}