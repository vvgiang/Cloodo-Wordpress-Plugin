<?php 
/**
 * Plugin Name:       demo Worksuite-OBJ
 * Plugin URI:        https://worksuite.cloodo.com/
 * Description:       Project management, trusted badge review
 * Version:           2.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Cloodo
 * Author URI:        https://cloodo.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cloodo-worksuite
 * Domain Path:       /languages
 */
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
add_action('init', function() {
	if ( is_user_logged_in() ) {
		define( 'CLWS_VERSION', '1.0.0' );
		define( 'CLWS_IFRAME_URL', 'https://worksuite.cloodo.com/' );
		define( 'CLWS_IFRAME_URL2', 'http://localhost:8222/login-app/' );
		//API user
		define( 'CLWS_API_LOGIN_URL', 'https://erp.cloodo.com/api/v1/auth/login' );
		define( 'CLWS_API_CREATE_URL', 'https://erp.cloodo.com/api/v1/create-user' );
		// API client
		define( 'CLWS_API_POST_CLIENT_URL', 'https://erp.cloodo.com/api/v1/client' );
		define( 'CLWS_API_GET_CLIENT_URL', 'https://erp.cloodo.com/api/v1/client/?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}&offset=0' );
		define( 'CLWS_API_GET_ALL_CLIENT_URL', 'https://erp.cloodo.com/api/v1/client/?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}&offset=0&limit=' );
		//API product
		define( 'CLWS_API_POST_PRODUCT_URL', 'https://erp.cloodo.com/api/v1/product' );
		define( 'CLWS_API_GET_PRODUCT_URL', 'https://erp.cloodo.com/api/v1/product/?fields=id,name,price,description,taxes,allow_purchase,category,hsn_sac_code&offset=0' );
		define( 'CLWS_API_GET_ALL_PRODUCT_URL', 'https://erp.cloodo.com/api/v1/product/?fields=id,name,price,description,taxes,allow_purchase,category,hsn_sac_code&offset=0&limit=' );
		//plugin path
		define( 'CLWS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'CLWS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		require_once( str_replace( '\\', '/', CLWS_PLUGIN_DIR.'includes/Clws_auto_load.php' ) ); 
	
	    ///////////////////// add menu page //////////////////
		$Clws_add_menu = new Clws_add_menu; 
		// echo $Clws_add_menu->hello();
		// echo $Clws_add_menu->world();
		// add_action('admin_menu', [$Clws_add_menu,'Register']);

    }
});








