<?php
/**
 * @package PlacementPartner
 * @version 1.0
 */
/*
Plugin Name: Placement Partner Vacancies
Plugin URI: http://www.mandelbrot.co.za
Description: Add your Placement Partner vacancies to Wordpress.
Author: Mandelbrot Technologies (Pty) Ltd
Version: 1.0
Author URI: http://www.mandelbrot.co.za
Licence: GPL2

Copyright 2012  Parallel Software (Pty) Ltd  (email : tech@parallel.co.za)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require_once('vacancies/placementpartner_vacancies_widget.php');
require_once('vacancies/placementpartner_vacancies_shortcodes.php');
require_once('vacancies/placementpartner_vacancies_region_shortcodes.php');
require_once('vacancies/placementpartner_vacancies_search_shortcodes.php');
require_once('admin/placementpartner_admin.php');
require_once('nusoap/nusoap.php');
/**
 * Register the vacancy search css
 */
function wptuts_styles_with_the_lot() {  
                    // Register the style like this for a plugin:  
                    wp_register_style( 'site', plugins_url( '/vacancies/includs/css/site.css', __FILE__ ), array(), '20120208', 'all' );  
                    // For either a plugin or a theme, you can then enqueue the style:  
                    wp_enqueue_style( 'site' );  
}
/**
 * Register the placement widget
 */
function registerWidgets() {
	register_widget("PlacementPartner_Vacancies_Widget");
}
/**
 * init_sessions()
 *
 * @uses session_id()
 * @uses session_start()
 */
function init_sessions() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'init_sessions');
/**
 * Add actions, options and shortcodes
 */
add_action( 'wp_enqueue_scripts', 'wptuts_styles_with_the_lot' );  
add_action('widgets_init', "registerWidgets");
add_action('admin_menu', array('PlacementPartner_Admin', 'addOptionsPage'));
add_action('admin_init', array('PlacementPartner_Admin', 'registerOptions'));

add_action('init', 'ilc_farbtastic_script');
function ilc_farbtastic_script() {
  wp_enqueue_style( 'farbtastic' );
  wp_enqueue_script( 'farbtastic' );
}

// Set the default values for the Placement Partner Web Service if not already set
// TODO: Set this only when plugin is initialised
$webservice['wsdl_url'] = 'http://www.placementpartner.co.za/ws/clients/?wsdl';
add_option('placementpartner_advanced_options', $webservice, '', 'yes');

// Add shortcodes
add_shortcode('placement_partner_vacancy_detail', array('placementpartner_vacancies_shortcodes', 'vacancy_detail'));
add_shortcode('placement_partner_vacancy_detail_region', array('placementpartner_vacancies_region_shortcodes', 'vacancy_detail'));
add_shortcode('placement_partner_vacancy_search', array('placementpartner_vacancies_search_shortcodes', 'search_detail'));