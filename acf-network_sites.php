<?php
/*
Plugin Name: Advanced Custom Fields: Network Sites
Plugin URI: https://github.com/halgatewood/acf-networksites-field
Description: Creates a select box of your WordPress Multisite blogs for the plugin Advanced Custom Fields
Version: 1.0.0
Author: Hal Gatewood
Author URI: http://halgatewood.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class acf_field_network_sites_plugin
{
	
	function __construct()
	{
		
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));	

		
		// version 3-
		add_action( 'init', array( $this, 'init' ));
	}
	
	
	/*
	*  Init
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function init()
	{
		if(function_exists('register_field'))
		{ 
			register_field('acf_field_network_sites', dirname(__File__) . '/network_sites-v3.php');
		}
	}
	
	/*
	*  register_fields
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function register_fields()
	{
		include_once('network_sites-v4.php');
	}
	
}

new acf_field_network_sites_plugin();
		
?>