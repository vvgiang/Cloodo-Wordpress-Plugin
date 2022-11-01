<?php 
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }
class Clws_resource {
    public static function view($path) {
        require_once(str_replace('\\','/',CLWS_PLUGIN_DIR.'views/'.$path));
    }
    public static function include($path) {
        require_once(str_replace('\\','/',CLWS_PLUGIN_DIR.'includes/'.$path));
    }
}