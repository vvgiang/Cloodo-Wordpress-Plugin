<?php
function cw_add_style(){
    function cw_addstyle(){
        wp_register_style( 'cw-boostrap',plugins_url('admin/css/bootstrap.css',__DIR__));
        wp_enqueue_style('cw-boostrap');
        wp_register_style( 'cw-style',plugins_url('admin/css/style-project.css',__DIR__));
        wp_enqueue_style('cw-style');
        wp_register_style( 'cw-awesome',plugins_url('admin/fontawesome/css/all.min.css',__DIR__));
        wp_enqueue_style('cw-awesome');
        wp_register_script( 'cw-modal',plugins_url('admin/js/bootstrapjs.min.js',__DIR__));
        wp_enqueue_script('cw-modal');
        wp_enqueue_script('jQuery');
        wp_register_script( 'cw-script',plugins_url('admin/js/script-project.js',__DIR__));
        wp_enqueue_script('cw-script');
    }
    add_action('admin_enqueue_scripts', 'cw_addstyle');
}
add_action('init','cw_add_style');


