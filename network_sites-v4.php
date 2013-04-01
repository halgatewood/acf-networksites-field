<?php

class acf_field_network_sites extends acf_field
{
	var $settings, $defaults;
		
	function __construct()
	{
		$this->name = 'network_sites';
		$this->label = __('Network Sites');
		$this->category = __("Multisite",'acf');
		
    	parent::__construct(); // do not delete!
    	
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}
	
	function create_options( $field ) { }
	
	function create_field( $field )
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


// create field
new acf_field_network_sites();

?>