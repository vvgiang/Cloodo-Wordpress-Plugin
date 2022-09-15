<?php
function clws_addstyle()
{
    if (isset($_GET['page']) && $_GET['page']=='project_list') {
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
    }elseif(isset($_GET['page']) && $_GET['page']=='lead'){
        wp_register_style( 'clws-boostrap',plugins_url('admin/css/bootstrap.css',__DIR__));
        wp_enqueue_style('clws-boostrap');
        wp_register_style( 'clws-awesome-font',plugins_url('admin/css/fontawesome.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-font');
        wp_register_style( 'clws-awesome-brands',plugins_url('admin/css/brands.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-brands');
        wp_register_style( 'clws-awesome-solid',plugins_url('admin/css/solid.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-solid');
        wp_register_script( 'clws-modal',plugins_url('admin/js/bootstrapjs.min.js',__DIR__));
        wp_enqueue_script('clws-modal');
        wp_enqueue_script('jQuery');
        wp_register_script( 'clws-sweet',plugins_url('admin/js/sweetalert.min.js',__DIR__));
        wp_enqueue_script('clws-sweet');
        wp_register_script( 'filter-ajax',plugins_url('admin/js/script-lead.js',__DIR__));
        wp_register_style( 'clws-style',plugins_url('admin/css/style-lead.css',__DIR__));
        wp_enqueue_style('clws-style');
        wp_localize_script( 'filter-ajax', 'filter_ajax_object',
            array( 
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'getSiteUrl' => get_site_url(),
                'pageNum'=> isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : 1,
                
            )   
        );
        wp_enqueue_script( 'filter-ajax' );
    }elseif(isset($_GET['page']) && $_GET['page']=='Setting'){
        wp_register_style( 'clws-boostrap',plugins_url('admin/css/bootstrap.css',__DIR__));
        wp_enqueue_style('clws-boostrap');
        wp_register_style( 'clws-awesome-font',plugins_url('admin/css/fontawesome.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-font');
        wp_register_style( 'clws-awesome-brands',plugins_url('admin/css/brands.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-brands');
        wp_register_style( 'clws-awesome-solid',plugins_url('admin/css/solid.min.css',__DIR__));
        wp_enqueue_style('clws-awesome-solid');
        wp_register_script( 'clws-modal',plugins_url('admin/js/bootstrapjs.min.js',__DIR__));
        wp_enqueue_script('clws-modal');
        wp_enqueue_script('jQuery');
        wp_register_script( 'clws-sweet',plugins_url('admin/js/sweetalert.min.js',__DIR__));
        wp_enqueue_script('clws-sweet');
        wp_register_script( 'filter-ajax',plugins_url('admin/js/script-lead.js',__DIR__));
        wp_register_style( 'clws-style',plugins_url('admin/css/style-lead.css',__DIR__));
        wp_enqueue_style('clws-style');
        wp_localize_script( 'filter-ajax', 'filter_ajax_object',
            array( 
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'getSiteUrl' => get_site_url(),
                'pageNum'=> isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : 1,
                
            )   
        );
        wp_enqueue_script( 'filter-ajax' );
    }
}
add_action('admin_enqueue_scripts', 'clws_addstyle');




