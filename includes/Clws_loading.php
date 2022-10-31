<?php 
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
class Clws_loading {
    public function __construct() {
        if ( !wp_doing_ajax() ) {
            $extension = isset($_GET['page'])? sanitize_text_field($_GET['page']) : "";
            $allows = ['dashboard', 'work', 'leads','clients','notice','messages','product','setting'];
            if (in_array($extension, $allows)) {
                echo '<div id="loading"></div>';             
            }
        }
    }
    public static function clws_hiden_loading() {
        echo'<style>
                #loading {
                    display: none;
                }
            </style>';
}
}