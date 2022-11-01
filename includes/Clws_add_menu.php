<?php
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }
class Clws_add_menu {
    // use demo, hello;
    public static $email_adm;
    public static $user_id;
    public static $user_data;
    public static $name_site;
    public static $user_login;
    public static $user_email;
    public static $company_name;
    public function __construct() {
        self::$email_adm = sanitize_text_field( get_option( 'admin_email'));
        self::$user_id = get_current_user_id();
        self::$user_data = get_userdata( self::$user_id );
        self::$name_site = get_bloginfo();
        self::$user_login = sanitize_text_field( self::$user_data->user_login );
        self::$user_email = sanitize_email( self::$user_data->user_email );
        self::$company_name = ( explode('.', self::$name_site) )[0];
        add_action('admin_menu', function() {
            $dashboard = new Clws_dashboard;
            new Clws_loading;
            add_menu_page(
                'dashboard', // title menu
                'Worksuite', // name menu
                'manage_options',// area supper admin and admin 
                'dashboard', // Slug menu
                [$dashboard, 'clws_access_dashboard'], // display function 
                'dashicons-businessman', // icon menu
                '7'
            );
            if (!empty(get_option( 'cloodo_token' ))) {
                $work = new Clws_works;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'work', // title page
                    'Work', // name menu
                    'manage_options', // area supper admin and admin
                    'work', // Slug menu
                    [$work, 'clws_access_works'], // display function
                );
                $lead = new Clws_leads;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'lead curd', // title page
                    'Leads', // name menu
                    'manage_options', // area supper admin and admin
                    'leads', // Slug menu
                    [$lead, 'clws_access_leads'], // display function
                );
                $client = new Clws_client;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'clients', // title page
                    'Clients', // name menu
                    'manage_options', // area supper admin and admin
                    'clients', // Slug menu
                    [$client, 'clws_access_clients'], // display function
                );
                $notice = new Clws_notice;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'notice', // title page
                    'Notice', // name menu
                    'manage_options', // area supper admin and admin
                    'notice', // Slug menu
                    [$notice, 'clws_access_notice'], // display function
                );
                $messages = new Clws_messages;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'messages', // title page
                    'Messages', // name menu
                    'manage_options', // area supper admin and admin
                    'messages', // Slug menu
                    [$messages, 'clws_access_messages'], // display function
                );
                $product = new Clws_product;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'Product', // title page
                    'Products', // name menu
                    'manage_options', // area supper admin and admin
                    'product', // Slug menu
                    [$product, 'clws_access_products'], // display function
                );
                $setting = new Clws_setting;
                add_submenu_page(
                    'dashboard', // Slug menu parent
                    'setting', // title page
                    'Setting', // name menu
                    'manage_options', // area supper admin and admin
                    'setting', // Slug menu
                    [$setting, 'clws_access_setting'], // display function
                );
            }
        });
    }
}