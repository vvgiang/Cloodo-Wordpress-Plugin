<?php
require_once( str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_resource.php' ) ); 

    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }
    $files = scandir(__DIR__, 0);
    $total = count($files);
    for ( $i = 2; $i < $total; $i++ )
        Clws_resource::include($files[$i]);
