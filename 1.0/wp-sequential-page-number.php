<?php 
/**
 * Plugin Name: WP Sequential Page Number
 * Plugin URI: https://manaf.co.in/
 * Description: WP Sequential Page Number is a WordPress plugin to generate a sequential page number
 * Author: Abdul Manaf M
 * Author URI: https://www.linkedin.com/in/manafm/
 * Version: 1.0
 * Text Domain: wpspn
 * Tested up to: 5.4
 * License: GPL3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package wpspn
 */

if(!defined('ABSPATH')) {
	exit;
}

if(!function_exists('wpspn_register')) {
    add_action('init', 'wpspn_register');
    function wpspn_register() {
        add_filter('manage_page_posts_columns', 'wpspn_sequential_page_columns_head', 10);
        add_filter('manage_edit-page_sortable_columns', 'wpspn_sequential_page_sortable_columns_head');
        add_action('manage_page_posts_custom_column', 'wpspn_sequential_page_columns_content', 10, 2);
        add_action('wp_insert_post', 'wpspn_set_sequential_page_id', 10, 2 );
    }
}
if(!function_exists('wpspn_activate')) {
    function wpspn_activate(){
        register_uninstall_hook( __FILE__, 'wpspn_uninstall' );
    }
    register_activation_hook( __FILE__, 'wpspn_activate' );
}

if(!function_exists('wpspn_uninstall')) {
    function wpspn_uninstall(){

    }
}

require_once( plugin_dir_path(__FILE__) . '/inc/numbering.php' );