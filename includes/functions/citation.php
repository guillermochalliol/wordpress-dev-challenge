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
 * Add  metabox and Customn Field with wp-editor
 *
 * @return metabox
 */
function add_custom_field_citation() {
    if(get_option('post_type_post')){
        add_meta_box( 'custom_field_citation', 'Citation', 'custom_field_citation_callback', 'post', 'normal', 'high' );
    };
    if(get_option('post_type_page')){
        add_meta_box( 'custom_field_citation', 'Citation', 'custom_field_citation_callback', 'page', 'normal', 'high' );
    };
}
add_action( 'add_meta_boxes', 'add_custom_field_citation' );

/**
 * 
 * Create  the citation custom field
 *
 * @param array $post  Wordpress Post
 * @return customfield
 */
function custom_field_citation_callback( $post ) {
    wp_nonce_field( 'custom_field_citation_nonce', 'custom_field_citation_nonce' );
    $content = get_post_meta( $post->ID, '_custom_field_citation_key', true );
	$editor_id = '_custom_field_editor';
	$settings = array(
	'textarea_name' => 'custom_field_citation',
	'editor_class' => 'custom_field_class',
	);
    echo '<p>To display the citations for this post use the following Short Code</p>';
    echo '<h4>[mc-citation post_id="'.$post->ID.'"]</h4>';
    wp_editor( $content, $editor_id, $settings );
}

/**
 * 
 * Save the citation custom field
 *
 * @param int $post_id  Wordpress Post ID
 * @return boolean
*/
function save_custom_field_citation_data( $post_id ) {
    if ( ! isset( $_POST['custom_field_citation_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['custom_field_citation_nonce'], 'custom_field_citation_nonce' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( isset( $_POST['post_type'] ) && 'post' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }
    if ( ! isset( $_POST['custom_field_citation'] ) ) {
        return;
    }
    $data = wp_kses_post( $_POST['custom_field_citation'] );
    update_post_meta( $post_id, '_custom_field_citation_key', $data );
}
add_action( 'save_post', 'save_custom_field_citation_data' );



/**
 * 
 * add the citation Shortcode
 *
 * @param array $atts  Shortcode attribures
 * @param array $atts  Shortcode content default null
 * @return boolean
*/

function add_mc_citation($attrs, $content = null) {
    global $post;
    
    $attributes = shortcode_atts( array(
        'post_id' => ''
    ), $attrs );
    
    esc_attr($attributes['post_id'])?$pid=esc_attr($attributes['post_id']):$pid=$post->ID;
    $content = get_post_meta( $pid, '_custom_field_citation_key', true );
    
    return $content;
}

add_shortcode("mc-citation", "add_mc_citation");