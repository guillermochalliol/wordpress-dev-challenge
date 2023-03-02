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
 * add Ajax call for Table data
 *
 * @return json table data
*/

function links_ajax_endpoint(){
    
    $response = []; 
    
    //Get WordPress posts - you can get your own custom posts types etc here
    $posts = get_data();
    
    //Add two properties to our response - 'data' and 'recordsTotal'
    $response['data'] = !empty($posts) ? $posts : []; //array of post objects if we have any, otherwise an empty array        
    $response['recordsTotal'] = !empty($posts) ? count($posts) : 0; //total number of posts without any filtering applied
    
    echo json_encode($response); //json_encodes our $response and sends it back with the appropriate headers
    wp_die();
}

add_action('wp_ajax_links_endpoint', 'links_ajax_endpoint'); //logged in
add_action('wp_ajax_no_priv_links_endpoint', 'links_ajax_endpoint'); //not logged in

