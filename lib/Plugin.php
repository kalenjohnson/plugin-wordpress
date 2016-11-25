<?php
namespace FatPanda\WordPress;

use Illuminate\Support\Str;
use FatPanda\Illuminate\WordPress\Http\Router;

/**
 * Baseclass for all WordPress plugins.
 */
abstract class Plugin {

	protected $mainFile;

	protected $pluginName;

	protected $pluginUri;

	protected $description;

	protected $version;

	protected $author;

	protected $authorUri;

	protected $license;

	protected $licenseUri;

	protected $pluginData;

	protected $registeredDataTypes = [];

	protected $router;

	protected $routerNamespace;

	protected $routerVersion;

	function __construct($mainFile)
	{
		if (!file_exists($mainFile)) {
			throw new \Exception("Main file $mainFile does not exist!");
		}

		$this->mainFile = $mainFile;
		$this->pluginData = get_plugin_data($this->mainFile);
		
		foreach($this->pluginData as $key => $value) {
			$propertyName = Str::camel($key);
			$this->{$propertyName} = $value;
		}

		$this->setRouterNamespace( Str::slug($this->pluginName) );

		// just use the major version number
		$routerVersion = 'v1';
		if (!preg_match('/(\d+).*?/', $this->version, $matches)) {
			$routerVersion = $matches[1];
		}

		$this->setRouterVersion($routerVersion);

		register_activation_hook($this->mainFile, [ $this, 'activate' ]);
		register_deactivation_hook($this->mainFile, [ $this, 'deactivate' ]);
		add_action('plugins_loaded', [ $this, 'loadTextDomain' ]);
	}

	function loadTextDomain()
	{
		load_plugin_textdomain( $this->textDomain, false, 
			dirname( plugin_basename($this->mainFile) ) . rtrim($this->domainPath, '/') . '/' );
	}

	function getPluginBasePath()
	{
		return dirname($this->mainFile);
	}

	function getPluginData()
	{
		return $this->pluginData;
	}

	function make()
	{
		$this->router = $router = new Router($this->routerNamespace, $this->routerVersion);
		
		if (!empty($this->registeredDataTypes)) {

		}

		$plugin = $this;

		require $this->getPluginBasePath() . '/src/Http/routes.php';
	}

	function setRouterNamespace($namespace)
	{
		$this->routerNamespace = $namespace;
		return $this;
	}

	function setRouterVersion($version)
	{
		$this->routerVersion = $version;
		return $this;
	}

	function setControllerClasspath($classpath)
	{
		$this->controllerClasspath = $classpath;
		return $this;
	}

	abstract function activate();

	abstract function deactivate();

	function register($customDataType)
	{
		$this->registeredDataTypes[] = $customDataType;
	}

	/**
	 * Begin interactive process of generating a new WordPress plugin project.
	 */
	static function create()
	{
		// make sure we've bootstrapped Composer
		require_once static::getBasePath().'/vendor/autoload.php';

		$tokens = [];

		// make sure we have a stub to work with
		try {
			$plugin = static::getStub('plugin');
			$main = static::getStub('main');
		} catch (\Exception $e) {
			\cli\out("%1".$e->getMessage()."%n\n");
			exit;
		}

		\cli\out("%4Let's create a WordPress plugin!%n\n");
		
		$tokens['@@PLUGIN_NAME@@'] = \cli\prompt("What do you want to call your plugin?", "My Plugin");
		$tokens['@@PLUGIN_DESCRIPTION@@'] = \cli\prompt("What will this plugin do? Be succinct.", "Do something amazing.");

		$tokens['@@PLUGIN_LICENSE@@'] = \cli\prompt("What should the plugin license be?", "GPL2");
		$tokens['@@PLUGIN_LICENSE_URI@@'] = \cli\prompt("At what URL can more information about the license be found?", 
			"https://www.gnu.org/licenses/gpl-2.0.html");

		$tokens['@@PLUGIN_CLASS_NAME@@'] = Str::studly($tokens['@@PLUGIN_NAME@@']);
		$tokens['@@PLUGIN_VAR_NAME@@'] = '_' . Str::slug($tokens['@@PLUGIN_NAME@@'], '_');

		$tokens['@@PLUGIN_VERSION@@'] = \cli\prompt("What should the base version be?", "1.0.0");
		
		$tokens['@@PLUGIN_AUTHOR@@'] = \cli\prompt("Who is the author of this plugin?", get_current_user());
		
		$tokens['@@PLUGIN_AUTHOR_URI@@'] = \cli\prompt("What is the URL of the author's homepage?", 
			"https://github.com/" . Str::slug($tokens['@@PLUGIN_AUTHOR@@']));
		
		$tokens['@@PLUGIN_URI@@'] = \cli\prompt("What is the URL of this project's homepage?", 
			 rtrim($tokens['@@PLUGIN_AUTHOR_URI@@'], '/') . '/' . Str::slug($tokens['@@PLUGIN_NAME@@']));

		$tokens['@@PLUGIN_NAMESPACE@@'] = \cli\prompt("What should the PHP namespace be for your plugin?", 
				Str::studly($tokens['@@PLUGIN_AUTHOR@@']) . '\\' . Str::studly($tokens['@@PLUGIN_NAME@@']));

		$tokens['@@PLUGIN_TEXT_DOMAIN@@'] = \cli\prompt("What is this plugin's text domain?", Str::slug($tokens['@@PLUGIN_NAME@@']));

		$tokens['@@PLUGIN_DOMAIN_PATH@@'] = \cli\prompt("Where will this plugin's translation files be stored?", "/lang");

		$plugin_file = self::getBasePath().'/src/plugin.php';
		if (file_exists($plugin_file)) {
			throw new \Exception("Can't create $plugin_file: it already exists.");
		}

		$main_file_name = \cli\prompt("What should we name the plugin's main file?", 
				Str::slug($tokens['@@PLUGIN_NAME@@']).".php");
		$main_file = self::getBasePath().'/'.$main_file_name;
		if (file_exists($main_file)) {
			throw new \Exception("Can't create $main_file: it already exists.");
		}

		file_put_contents($main_file, str_replace(array_keys($tokens), array_values($tokens), $main));
		file_put_contents($plugin_file, str_replace(array_keys($tokens), array_values($tokens), $plugin));

		return [
			'tokens' => $tokens,
			'files' => [ 'main' => $main_file, 'plugin' => $plugin_file ]
		];
	}

	static function getBasePath()
	{
		return realpath(__DIR__.'/../');
	}

	static function getStub($stub)
	{
		$file = self::getBasePath().'/stubs/'.$stub.'.stub';
		if (!file_exists($file)) {
			throw new \Exception("Can't find stub for '$stub'; looked in $file. Maybe withfatpanda/plugin-wordpress is corrupted?");
		}
		return file_get_contents($file);
	}

}