<?php
namespace FatPanda\WordPress;

use Illuminate\Filesystem\Filesystem;

/**
 * Manage a scratch space for testing plugins.
 */
class PluginWorkbench {

	function __construct()
	{
		$this->fs = new Filesystem();
	}

	function cleanup()
	{
		$path = static::getFilePath();
		if (file_exists($path)) {
			$allFiles = $this->fs->allFiles($path);
			$this->fs->delete($allFiles);
			$this->fs->deleteDirectory($path);
		}
	}

	function reset()
	{
		$this->cleanup();
		$this->create();
	}

	function create()
	{
		$this->fs->makeDirectory(self::getFilePath());
	}

	function makeDirectory($dir)
	{
		$this->fs->makeDirectory(self::getFilePath().'/'.ltrim($dir, '/'), 0755, true);
	}

	static function getFilePath()
	{
		return realpath(dirname(__FILE__).'/../').'/.workbench-cache';
	}
	
}