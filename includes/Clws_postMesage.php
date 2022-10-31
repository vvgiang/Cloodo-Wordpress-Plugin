<?php 
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }
class Clws_postMesage {
    public function __construct() {
        echo "
        <script>
            setTimeout(window.onload = function() {
                jQuery(document).find( '#login' ).remove();
                var myIfr = window.frames['iframeclws'].contentWindow;
                var val = myIfr.postMessage('".get_option('cloodo_token')."','".esc_url(CLWS_IFRAME_URL)."check-login');
            },3000)
        </script>";
    }
    
}