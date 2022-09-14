<?php
function clws_add_style(){
    function clws_addstyle(){
        wp_register_style( 'clws-boostrap',plugins_url('admin/css/bootstrap.css',__DIR__));
        wp_enqueue_style('clws-boostrap');
        wp_register_style( 'clws-style',plugins_url('admin/css/style-project.css',__DIR__));
        wp_enqueue_style('clws-style');
        wp_register_style( 'clws-awesome-font',plugins_url('admin/css/fontawesome.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-font');
        wp_register_style( 'clws-awesome-brands',plugins_url('admin/css/brands.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-brands');
        wp_register_style( 'clws-awesome-solid',plugins_url('admin/css/solid.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-solid');
        wp_register_script( 'clws-modal',plugins_url('admin/js/bootstrapjs.min.js',__DIR__));
        wp_enqueue_script('clws-modal');
        wp_enqueue_script('jQuery');
        wp_register_script( 'clws-script',plugins_url('admin/js/script-project.js',__DIR__));
        wp_enqueue_script('clws-script');
    }
    add_action('admin_enqueue_scripts', 'clws_addstyle');
}
add_action('init','clws_add_style');


