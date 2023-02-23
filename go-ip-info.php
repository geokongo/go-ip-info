<?php
/**
 * Plugin Name          
 *
 * @package           PluginPackage
 * @author            Geoffrey Okongo
 * @copyright         2023 (c) Geoffrey Okongo
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       GO IP Info
 * Plugin URI:        https://github.com/geokongo/go-ip-create
 * Description:       This WordPress plugins enables you fetch and display IP address information from the IP2Location API.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Geoffrey Okongo
 * Author URI:        https://geokongo.com
 * Text Domain:       go-ip-info
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://wordpress.com/plugins/go-ip-info
 */

 
//If this file is called directly, abort!
defined('ABSPATH') or die;

//autloader for loading plugin class files
spl_autoload_register(function($class){
    
    //define the plugin namespace
	$namespace = 'GOIPInfo';

    //check if the class belongs to this namespace
	if (strpos($class, $namespace) !== 0) {
		return;
	}

    $class = str_replace($namespace, 'includes', $class);
	$class = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($class) . '.php');
 	$class_path = __DIR__ . DIRECTORY_SEPARATOR . $class;
    
    //check if file exists before autoloading
	if (file_exists($class_path)) {
		require_once($class_path);
	}

});

/**
 * The code that runs during plugin activation
 */
function goipinfo_activate(){
    flush_rewrite_rules();
}

/**
 * The code that runs during plugin deactivation
 */
function goipinfo_deactivate(){
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'goipinfo_activate');
register_deactivation_hook(__FILE__, 'goipinfo_deactivate');


/**
 * Initialize all the core classes of the plugin
 */
if(class_exists('GOIPInfo\Init')){
    
    $goipinfo = new GOIPInfo\Init();
    $goipinfo->start();

}
