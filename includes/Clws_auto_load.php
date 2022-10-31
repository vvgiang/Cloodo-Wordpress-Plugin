<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
$files = scandir(__DIR__, 0);
$total = count($files);
for($i = 2; $i < $total; $i++)
require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/'.$files[$i] ));

    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_include.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_auto_load.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_add_menu.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_loading.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_API.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_postMesage.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_dashboard.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_views.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_works.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_leads.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_client.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_notice.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_message.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_product.php' ));
    // require_once(str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_setting.php' )); 