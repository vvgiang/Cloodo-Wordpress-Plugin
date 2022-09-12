<?php
function cw_addstyle()
{
    wp_register_style( 'cw-boostrap',plugins_url('admin/css/bootstrap.css',__DIR__));
    wp_enqueue_style('cw-boostrap');
    wp_register_style( 'cw-awesome',plugins_url('admin/fontawesome/css/all.min.css',__DIR__));
    wp_enqueue_style('cw-awesome');
    wp_register_script( 'cw-modal',plugins_url('admin/js/bootstrapjs.min.js',__DIR__));
    wp_enqueue_script('cw-modal');
    wp_enqueue_script('jQuery');
    wp_register_script( 'cw-sweet',plugins_url('admin/js/sweetalert.min.js',__DIR__));
    wp_enqueue_script('cw-sweet');
    wp_register_script( 'filter-ajax',plugins_url('admin/js/script-lead.js',__DIR__));
    wp_register_style( 'cw-style',plugins_url('admin/css/style-lead.css',__DIR__));
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




