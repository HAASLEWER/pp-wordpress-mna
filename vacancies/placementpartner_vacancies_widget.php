<?php
/**
 *
 * @author Anton Menkveld
 *
 *
 */

/*
 * Include the NuSoap library to be able to access the Placement Partner Web Service
 */
//require_once('placementpartner\nusoap\nusoap.php');

/**
 * Foo_Widget Class
 */
class PlacementPartner_Vacancies_Widget extends WP_Widget {
	/** constructor */
	function __construct() {
		// Create widget options
		$widget_opts = array(
						'classname' => 'PlacementPartner_Vacancies',
						'description' => 'Displays the current vacancies in your Placement Partner system.'
				);
		
		parent::WP_Widget( 
					'PlacementPartner_Vacancies_Widget',	// Widget base id
					'Placement Partner Vacancies', 	// Widget name
					$widget_opts
				);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		// embed the javascript file that makes the AJAX request
		wp_enqueue_script('PlacementPartner_Ajax', plugin_dir_url( __FILE__ ) . 'widgetAjax.js', array('jquery'));
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script('PlacementPartner_Ajax', 'PlacementPartner', array('ajaxurl' => admin_url('admin-ajax.php'),
																				'num_ads' => $instance['num_ads'],
																				'detail_page' => $instance['detail_page']));
		
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if (!empty( $title)) {
			echo $before_title . $title . $after_title;
		}

		include "widget.html";
		echo $after_widget;		
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['num_ads'] = strip_tags($new_instance['num_ads']);
		$instance['detail_page'] = strip_tags($new_instance['detail_page']);
		
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		// set form defaults
		$defaults = array(
					'title' => 'Current Jobs',
					'num_ads' => 5,
					'detail_page' => ''
				);
		
		$instance = wp_parse_args((array)$instance, $defaults);
		
		$title = strip_tags($instance['title']);
		$num_ads = strip_tags($instance['num_ads']);
		$detail_page = strip_tags($instance['detail_page']);
		
		// Include the HTML template for the form
		include('form.html');
	}

	function ajaxLoadVacancies() {
		// Get the vacancies from the Placement Partner Web Service
		// and convert to JSON
		$response = json_encode(self::_getVacancies($_POST['num_ads']));
		
		// Set output content type to json
		header("Content-Type: application/json");
		
		// Return the response to the client
		echo $response;
		
		// Stop any further execution
		exit;
	}
	
	/*
	 * Get the required vacancies from the Placement Partner Web Serivce
	 * by using the NuSoap library
	 */
	function _getVacancies($num_ads = 5) {
		$connectionError = false;
		$authenticationError = false;
		$functionError = false;
		$vacancies = array();

		// Get the user options from the WP Settings system
		$advanced_options = get_option('placementpartner_advanced_options');
		$login_options = get_option('placementpartner_logindetails_options');

		// Connect to the Placement Partner Web Service
		$client = new nusoap_client($advanced_options['wsdl_url'], true);		
		$err = $client->getError();
		if ($err) {
			$connectionError = true;
		} else {
			// Create a proxy object
			$pp = $client->getProxy();
			$err = $pp->getError();
			if ($err) {
				$connectionError = true;
			} else {
				// Login to the web service with the given username and password
				$session_id = $pp->login($login_options['username'], $login_options['password']);
				$err = $pp->getError();
				if ($err) {
					$authenticationError = true;
				} else {
					// Get the vacanies from the Placement Partner server
					// TODO: Give user the option for sorting.
					$filter = array(
								array("field" => "sort_by", "operator" => "desc", "value"=>"date")
							);
					
					$vacancies = $pp->getAdverts($session_id, $filter);
					$err = $pp->getError();
					if ($err) {
						$functionError = true;
					}
					// Logout
					$pp->logout($session_id);
				}
			}
		}		
		
		// Show nice error to the end user.
		if($connectionError) {
			echo "Could not connect to the Placement Partner server. Please contact the Placement Partner team.";
			return false;
		}
		if($authenticationError) {
			echo "Incorrect username and/or password returned by the Placement Partner server. Please check Placement Partner plugin settings.";
			return false;
		}
		if($functionError) {
			echo "Error communicating with the Placement Partner server. Please contact the Placement Partner technical team.";
			return false;
		}
		
		return array_slice($vacancies, 0 , $num_ads);
	}
	
} // class Foo_Widget

// Setup the Placement Partner Vacancy Widget
add_action('wp_ajax_nopriv_placementpartner-vacancies-widget-load', array('PlacementPartner_Vacancies_Widget', 'ajaxLoadVacancies'));
add_action('wp_ajax_placementpartner-vacancies-widget-load', array('PlacementPartner_Vacancies_Widget', 'ajaxLoadVacancies'));
