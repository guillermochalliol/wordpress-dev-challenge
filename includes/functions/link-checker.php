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
 * Validate url
 *
 * @param string $url  link url
 * @return string|int status of url
 */
function validate_url($url){
    // regex to valid url in http://www.php.net/manual/en/function.preg-match.php#93824
    $regex = "((https?|http?|ftp)\:\/\/)?"; // SCHEME 
    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
    $regex .= "(\:[0-9]{2,5})?"; // Port 
    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
    $parsed=parse_url($url);
   
    if (!preg_match("/^$regex$/i", $url)){
        return 'malformed';
    }else if (!array_key_exists("scheme", $parsed)){
        return "Undefined protocol";
    }
    else if (array_key_exists("scheme", $parsed)&&$parsed['scheme']==="http"){
        return "Insegurous link";
    }else{
        return check_response($url);
    }
}

/**
 * 
 * Extract all <a href="..."></a> links
 *
 *  NOTE  we can extract urls of post  by using wp_extract_urls( $content ) 
 *  But generate its Not links results such as in teh ciontyent exist /h.. is interpreted as  a link  (250km/h)
 * @param string $content  Post content
 * @return array  Links
*/
function get_content_links($content) {
    $regEx = '/href=["\']?([^"\'>]+)["\']?/';
    preg_match_all($regEx, $content, $matches);
    return $matches[1];
}

/**
 * 
 * Check link Response
 *
 * I decide use wp_remote:head instead curl since is a built in  WP  functionality
 * 
 * @param string $url  link url
 * @return int  url response status
*/

function check_response($url){
    $response = wp_remote_head( $url );
    $status = wp_remote_retrieve_response_code( $response );
    return $status;
    
}

/**
 * 
 * Get Data From Posts
 *
 * @return array  formated links array
*/
function get_data(){
    $posts = new WP_Query('post_type=post&posts_per_page=-1');
    $posts = $posts->posts;
    $data=[];
    foreach($posts as $post) {
        $content = get_post_field( 'post_content',$post->ID );
        //$links = wp_extract_urls( $content );
        $links=get_content_links($content);
        
        foreach ( $links as $link ) {
            // Use  this validator to log only differents to 20x and 30x (i've included since the links works but is redirected )
            if(!filter_var(validate_url($link),FILTER_VALIDATE_INT,array('options' => array('min_range' => 200,'max_range' => 399)))){
                $permalink = '<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
                $title = get_the_title($post->ID);
                $data[]=['url'=>$link,'title'=>$title, 'status'=>validate_url($link), 'permalink'=>$permalink];
               }
        }
    }    
    return $data;
}
