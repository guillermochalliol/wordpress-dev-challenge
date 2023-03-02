<?php
/**
  * @author Guillermo Challiol
  * @author Guillermo Challiol  <guillermochalliol@gmail.com>
  */
  
if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

/**
 * 
 * Define footnotes scripts and css
 *
 */ 
function links_enqueue_scripts() {
    $cssPath = FOOTNOTES_ASSETS.'/assets/css/';
    $jsPath = FOOTNOTES_ASSETS.'/assets/js/';
    global $parent_file;
    // Not load scripts if not in  Plugin page
    if (FOOTNOTES_PP !== $parent_file) {
        return;
    }
    //Data tables
    //CSS
    wp_enqueue_style('jquery-datatables-css', $cssPath. 'jquery.dataTables.min.css');
    wp_enqueue_style('footnotes-css',   $cssPath . 'footnotes.css');
    //JS
    wp_enqueue_script('jquery-datatables-js', $jsPath . 'dataTables.min.js',array('jquery'),true);
    //custom Js
    wp_enqueue_script('footnotes-js', $jsPath . 'footnotes.js',array('jquery'),true);
}

add_action( 'admin_enqueue_scripts', 'links_enqueue_scripts');

/**
 * 
 * Add admin page to the menu
 *
 */ 
function add_admin_page() {
    // add top level menu page
    add_menu_page(
    'Footnotes Settings', 
    'Footnotes', 
    'manage_options', 
    FOOTNOTES_PP, 
    'footnotes_options', //Callback 
    'dashicons-pressthis'
    );
}

add_action( 'admin_menu', 'add_admin_page');

/**
 * 
 * Register Settings
 *
 */ 
function footnotes_register_settings() {
    register_setting( 'footnotes_options', 'post_type_post', 'footnotes_sanitize_selected_values' );
    register_setting( 'footnotes_options', 'post_type_page', 'footnotes_sanitize_selected_values' );
}
add_action( 'admin_init', 'footnotes_register_settings' );

/**
 * 
 * return Field
 *
 */ 
function footnotes_sanitize_selected_values( $input ) {
    return $input;
}
