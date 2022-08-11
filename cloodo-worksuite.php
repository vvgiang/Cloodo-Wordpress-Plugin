<?php
/**
 * Plugin Name:       Cloodo Worksuite
 * Plugin URI:        https://worksuite.cloodo.com/
 * Description:       Project management, trusted badge review
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Cloodo
 * Author URI:        https://cloodo.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       cloodo-worksuite
 * Domain Path:       /languages
 */
function add_iframe(){
    $url= get_site_url();   
    $newurl = (explode("/",trim($url,"/")))[2] ;
    return '<iframe src="https://cloodo.com/trustscore/' . $newurl . '"'.'frameborder="0" width="auto" height="300px" scrolling="no" />';
}
add_shortcode( 'cloodo-badge', 'add_iframe' );