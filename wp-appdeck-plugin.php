<?php
/**
 * @package WP-Appdeck-Plugin
 * @author Yann Dubois / Appdeck
 * @version 0.1.0
 */

/*
 Plugin Name: WP Appdeck Plugin
 Plugin URI: http://www.yann.com/en/wp-plugins/wp-appdeck-plugin
 Description: Turns your WordPress site into a native mobile app for iOS and Android phones
 Version: 0.1.0
 Author: Yann Dubois / Appdeck
 Author URI: http://www.appdeck.mobi/
 License: GPL2
 */

/**
 * @copyright 2013  Yann Dubois / Appdeck  ( email : yann _at_ abc.fr )
 *
 *  Original development of this plugin was kindly co-funded by Appdeck
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


/**
 Revision 0.1.0:
 - Original alpha release 00
 */

/** Class includes **/
include_once( dirname( __FILE__ ) . '/inc/yd-widget-framework.inc.php' );	// standard framework VERSION 20110405-01 or better
include_once( dirname( __FILE__ ) . '/inc/wp-appdeck-main.inc.php' );		// custom classes

/** admin back-office submenu includes **
//TODO: don't declare this twice (in the class and here)
$submenus	= array(
		'dashboard',
		'advertisement',
		'statistics',
		'configuration',
		'push',
		'emulator',
		'publication'
);
foreach( $this->submenus as $submenu ) {
	include_once( dirname( __FILE__ ) . '/inc/admin/sub_' . $submenu . '.inc.php' );
} */

/**
 * Just fill up necessary settings in the configuration array
 * to create a new custom plugin instance...
 * 
 */
global $yd_apdk;
$yd_apdk = new ydApdkPlugin(
	array(
		'name' 				=> 'WP Appdeck Plugin',
		'version'			=> '0.1.0',
		'has_option_page'	=> false,
		'option_page_title' => 'Appdeck Settings',
		'op_donate_block'	=> false,
		'op_credit_block'	=> false,
		'op_support_block'	=> false,
		'has_toplevel_menu'	=> false,
		'has_shortcode'		=> false,
		'shortcode'			=> '',
		'has_widget'		=> false,
		'widget_class'		=> '',
		'has_cron'			=> false,
		'crontab'			=> array(),
		'has_stylesheet'	=> false,
		'stylesheet_file'	=> 'css/appdeck.css',
		'has_translation'	=> false,
		'translation_domain'=> 'appdeck_front.css', // must be copied in the widget class!!!
		'translations'		=> array(
			array( 'English', 'Yann Dubois', 'http://www.yann.com/' ),
			array( 'French', 'Yann Dubois', 'http://www.yann.com/' ),
		),		
		'initial_funding'	=> array( 'Appdeck', 'http://www.appdeck.mobi/' ),
		'additional_funding'=> array(),
		'form_blocks'		=> array(
			'Main options' => array( 
			)
		),
		'option_field_labels'=>array(
		),
		'option_defaults'	=> array(
		),
		'form_add_actions'	=> array(
		),
		'has_cache'			=> false,
		'option_page_text'	=> '',
		'backlinkware_text' => '',
		'plugin_file'		=> __FILE__,
		'has_activation_notice'	=> false,
		'activation_notice' => ''
 	)
);
?>