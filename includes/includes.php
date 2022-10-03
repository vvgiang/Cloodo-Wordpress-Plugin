<?php
function clws_addstyle()
{
    if (isset($_GET['page'])){
        switch ($_GET['page']) {
            case 'project_list':
                wp_register_style( 'clws-boostrap',plugins_url('admin/css/bootstrap.css',__DIR__));
                wp_enqueue_style('clws-boostrap');
                wp_register_style( 'clws-awesome-font',plugins_url('admin/css/fontawesome.min.css',__DIR__));
                wp_enqueue_style('clws-awesome-font');
                wp_register_style( 'clws-awesome-brands',plugins_url('admin/css/brands.min.css',__DIR__));
                wp_enqueue_style('clws-awesome-brands');
                wp_register_style( 'clws-awesome-solid',plugins_url('admin/css/solid.min.css',__DIR__));
                wp_enqueue_style('clws-awesome-solid');
                wp_register_style( 'clws-style',plugins_url('admin/css/style.css',__DIR__));
                wp_enqueue_style('clws-style');
                wp_register_script( 'clws-modal',plugins_url('admin/js/bootstrapjs.min.js',__DIR__));
                wp_enqueue_script('clws-modal');
                wp_enqueue_script('jQuery');
                wp_register_script( 'clws-sweet',plugins_url('admin/js/sweetalert.min.js',__DIR__));
                wp_enqueue_script('clws-sweet');
                wp_register_script( 'clws-script',plugins_url('admin/js/script.js',__DIR__));
                wp_enqueue_script('clws-script');
                wp_register_script( 'project-ajax',plugins_url('admin/js/script-project.js',__DIR__));
                wp_localize_script( 'project-ajax', 'project_ajax_object',
                    array( 
                        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                        'getSiteUrl' => get_site_url(),
                        'pageNum'=> isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : 1,
                        
                    )   
                );
                wp_enqueue_script( 'project-ajax' );
                break;
            case 'lead':
            case 'Setting':
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
                wp_register_style( 'clws-style',plugins_url('admin/css/style.css',__DIR__));
                wp_enqueue_style('clws-style');
                wp_enqueue_script('jQuery');
                wp_register_script( 'clws-sweet',plugins_url('admin/js/sweetalert.min.js',__DIR__));
                wp_enqueue_script('clws-sweet');
                wp_register_script( 'clws-script',plugins_url('admin/js/script.js',__DIR__));
                wp_enqueue_script('clws-script');
                wp_register_script( 'lead-ajax',plugins_url('admin/js/script-lead.js',__DIR__));
                wp_localize_script( 'lead-ajax', 'lead_ajax_object',
                    array( 
                        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                        'getSiteUrl' => get_site_url(),
                        'pageNum'=> isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : 1,
                        
                    )   
                );
                wp_enqueue_script( 'lead-ajax' );
                break;
            case 'Client':
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
                wp_register_style( 'clws-style',plugins_url('admin/css/style.css',__DIR__));
                wp_enqueue_style('clws-style');
                wp_enqueue_script('jQuery');
                wp_register_script( 'clws-sweet',plugins_url('admin/js/sweetalert.min.js',__DIR__));
                wp_enqueue_script('clws-sweet');
                wp_register_script( 'clws-script',plugins_url('admin/js/script.js',__DIR__));
                wp_enqueue_script('clws-script');
                wp_register_script( 'client-ajax',plugins_url('admin/js/script-client.js',__DIR__));
                wp_localize_script( 'client-ajax', 'client_ajax_object',
                    array( 
                        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                        'getSiteUrl' => get_site_url(),
                        'data'=> isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : 1,
                        
                    )   
                );
                wp_enqueue_script( 'client-ajax' );
                break;
            default:
                // code
                break;
        }
    }
}
add_action('admin_enqueue_scripts', 'clws_addstyle');




