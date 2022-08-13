<?php
function initadd(){
    function adminstyle(){
        wp_enqueue_style( 'stylecss',plugin_dir_url(__DIR__).'admin/css/style.css');
        wp_enqueue_style( 'boostrapcss',plugin_dir_url(__DIR__).'admin/css/bootstrap.css');
        wp_enqueue_style( 'awesomecss',plugin_dir_url(__DIR__).'admin/fontawesome/css/fontawesome.min.css');
        wp_enqueue_style( 'awesomecss1','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css');
        wp_enqueue_script( 'jqre','https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js');
        wp_enqueue_script( 'jqr',plugin_dir_url(__DIR__).'admin/js/jquery.js');
        wp_enqueue_script( 'script',plugin_dir_url(__DIR__).'admin/js/script.js');
    }
    add_action('admin_enqueue_scripts', 'adminstyle');
}
add_action('init','initadd');   
