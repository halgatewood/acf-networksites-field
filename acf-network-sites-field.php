<?php
/*
Plugin Name: Advanced Custom Fields - Network Sites Add-on
Plugin URI: http://www.advancedcustomfields.com/
Description: Creates a select box of your WordPress Multisite blogs.
Version: 1.0
Author: Hal Gatewood
Author URI: http://www.halgatewood.com/
License: GPL
Copyright: Elliot Condon, Hal Gatewood
*/

	
if( !class_exists( 'ACF_NetworkSites_Field' ) && class_exists( 'acf_Field' ) ) 
{
	class ACF_NetworkSites_Field extends acf_Field
	{
		function __construct($parent)
		{
	    	parent::__construct($parent);
	    	$this->name = 'network_sites'; // variable name (no spaces / special characters / etc)
			$this->title = __("Network Sites",'acf'); // field label (Displayed in edit screens)
	   	}	
	
		function create_options($key, $field) { }
	
		function create_field($field)
		{
			// GET ALL SITES
			global $wpdb;
			$sites = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->blogs WHERE archived = '0' AND deleted = '0' ORDER BY blog_id" ) );
	
			$field['choices'] = $sites;
		
			echo '<select id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '">';	
			
			foreach($field['choices'] as $key => $value)
			{
					$selected = '';
				if($value->blog_id == $field['value'])
				{
						$selected = ' selected="selected"';
				}
		
				echo '<option value="'.$value->blog_id.'"'.$selected.'>'.$value->domain.$value->path.'</option>';
			}
	
			echo '</select>';
			
		}
	}
}

if( !class_exists( 'ACF_NetworkSites_Field_Helper' ) )
{
	class ACF_NetworkSites_Field_Helper 
	{
		private static $instance;
		
		public static function singleton() 
		{
			if( !isset( self::$instance ) ) 
			{
				$class = __CLASS__;
				self::$instance = new $class();
			}
			return self::$instance;
		}
		
		private function __clone() { }
		
		const L10N_DOMAIN = 'acf-networksites-field';
		
		private function __construct() 
		{
			add_action( 'init', array( &$this, 'register_field' ),  5, 0 );
		}
		
		public function register_field() 
		{
			if( function_exists( 'register_field' ) ) 
			{
				register_field( 'ACF_NetworkSites_Field', __FILE__ );
			}
		}
	}
}

ACF_NetworkSites_Field_Helper::singleton();

?>