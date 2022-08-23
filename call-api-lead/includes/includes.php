<?php
function cw_addstyle(){
    wp_register_style( 'cw-boostrap',plugin_dir_url(__DIR__).'admin/css/bootstrap.css');
    wp_enqueue_style('cw-boostrap');
    wp_register_style( 'cw-style',plugin_dir_url(__DIR__).'admin/css/style.css');
    wp_enqueue_style('cw-style');
    wp_register_style( 'cw-awesome',plugin_dir_url(__DIR__).'admin/fontawesome/css/all.min.css');
    wp_enqueue_style('cw-awesome');
    wp_register_script( 'cw-modal',plugin_dir_url(__DIR__).'admin/js/bootstrapjs.min.js');
    wp_enqueue_script('cw-modal');
    wp_enqueue_script('jQuery');
    wp_register_script( 'cw-script',plugin_dir_url(__DIR__).'admin/js/script.js');
    wp_enqueue_script('cw-script');
    wp_register_script( 'filter-ajax',plugin_dir_url(__DIR__).'admin/js/script.js');
    wp_localize_script( 'filter-ajax', 'filter_ajax_object',
        array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'getsiteurl' => get_site_url(),
        )
    );
    wp_enqueue_script( 'filter-ajax' );
}
add_action('admin_enqueue_scripts', 'cw_addstyle');



