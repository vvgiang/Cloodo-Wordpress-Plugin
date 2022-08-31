<?php
function cw_addstyle()
{
    wp_register_style( 'cw-boostrap',plugin_dir_url(__DIR__).'admin/css/bootstrap.css');
    wp_enqueue_style('cw-boostrap');
    wp_register_style( 'cw-awesome',plugin_dir_url(__DIR__).'admin/fontawesome/css/all.min.css');
    wp_enqueue_style('cw-awesome');
    wp_register_script( 'cw-modal',plugin_dir_url(__DIR__).'admin/js/bootstrapjs.min.js');
    wp_enqueue_script('cw-modal');
    wp_enqueue_script('jQuery');
    wp_register_script( 'cw-sweet',plugin_dir_url(__DIR__).'admin/js/sweetalert.min.js');
    wp_enqueue_script('cw-sweet');
    wp_register_script( 'filter-ajax',plugin_dir_url(__DIR__).'admin/js/script.js');
    wp_register_style( 'cw-style',plugin_dir_url(__DIR__).'admin/css/style.css');
    wp_enqueue_style('cw-style');
    wp_localize_script( 'filter-ajax', 'filter_ajax_object',
        array( 
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'getSiteUrl' => get_site_url(),
            'pageNum'=> isset($_GET['pageNum']) ? $_GET['pageNum'] : 1,
            
        )   
    );
    wp_enqueue_script( 'filter-ajax' );
}
add_action('admin_enqueue_scripts', 'cw_addstyle');




