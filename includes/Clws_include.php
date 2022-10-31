<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
add_action('admin_enqueue_scripts', function() {
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'dashboard':
            case 'work':
            case 'leads':
            case 'clients':
            case 'notice':
            case 'messages':
            case 'product':
            case 'setting':
                wp_register_style('clws-boostrap', CLWS_PLUGIN_URL.'admin/css/bootstrap.css');
                wp_enqueue_style('clws-boostrap');
                wp_register_style('clws-awesome-font', CLWS_PLUGIN_URL.'admin/css/fontawesome.min.css');
                wp_enqueue_style('clws-awesome-font');
                wp_register_style('clws-awesome-brands', CLWS_PLUGIN_URL.'admin/css/brands.min.css');
                wp_enqueue_style('clws-awesome-brands');
                wp_register_style('clws-awesome-solid', CLWS_PLUGIN_URL.'admin/css/solid.min.css');
                wp_enqueue_style('clws-awesome-solid');
                wp_register_script('clws-modal', CLWS_PLUGIN_URL.'admin/js/bootstrapjs.min.js');
                wp_enqueue_script('clws-modal');
                wp_register_style('clws_style', CLWS_PLUGIN_URL.'admin/css/style.css');
                wp_enqueue_style('clws_style');
                wp_enqueue_script('jQuery');
                wp_register_script('clws-sweet', CLWS_PLUGIN_URL.'admin/js/sweetalert.min.js');
                wp_enqueue_script('clws-sweet');
                wp_register_script('clws-script', CLWS_PLUGIN_URL.'admin/js/script.js');
                wp_localize_script(
                    'clws-script',
                    'script_object',
                    array(
                        'ajaxUrl' => admin_url('admin-ajax.php'),
                        'getSiteUrl' => get_site_url(),
                        'token'=> get_option('cloodo_token'),
                        'urlIframe' => esc_url(CLWS_IFRAME_URL)
                    )
                );
                wp_enqueue_script('clws-script');
            default:
                break;
        }
    }
});