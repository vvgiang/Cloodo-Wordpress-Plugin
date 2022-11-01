<?php 
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
class Clws_works extends Clws_API {
    public static function clws_access_works() {
        if ( class_exists( 'WooCommerce' ) ) {
            
        }
        Clws_resource::view('project.php');
    }
}