<?php
/**
 * Plugin Name:       Cloodo work Suite
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
/////////////////test site /////////////////
define("CLWS_IFRAME_URL", "https://worksuite.cloodo.com/");
//////////////////////////////////////////////////require////////////////////////////////////////////////////
require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'includes/includes.php'));
// //////////////////////////////////////////////////add_iframe///////////////////////////////////////////////// 
function clws_add_iframe() {
    $url= sanitize_url(get_site_url());   
    $newurl = sanitize_text_field((explode("/",trim($url,"/")))[2]);
    return '<iframe src="'. esc_url('https://cloodo.com/trustscore/'.$newurl) . '"'.'frameborder="0" width="auto" height="300px" scrolling="no" />';
}
add_shortcode( 'cloodo-badge', 'clws_add_iframe' );

////////////////////////////////////////////////add menu page///////////////////////////////////////////////////

add_action('admin_menu', function() {
    add_menu_page(
        'dashboard', // title menu
        'Worksuite', // name menu
        'manage_options',// area supper admin and admin 
        'dashboard', // Slug menu
        'clws_access_dashboard', // display function 
        'dashicons-businessman', // icon menu
        '7'
    );
    if (!empty(get_option('cloodo_token'))) {
        add_submenu_page(
            'dashboard', // Slug menu parent
            'work', // title page
            'Work', // name menu
            'manage_options', // area supper admin and admin
            'work', // Slug menu
            'clws_access_getall_works', // display function
        );
        add_submenu_page(
            'dashboard', // Slug menu parent
            'lead curd', // title page
            'Leads', // name menu
            'manage_options', // area supper admin and admin
            'leads', // Slug menu
            'clws_access_getall_leads', // display function
        );
        add_submenu_page(
            'dashboard', // Slug menu parent
            'clients', // title page
            'Clients', // name menu
            'manage_options', // area supper admin and admin
            'clients', // Slug menu
            'clws_access_getall_clients', // display function
        );
        add_submenu_page(
            'dashboard', // Slug menu parent
            'notice', // title page
            'Notice', // name menu
            'manage_options', // area supper admin and admin
            'notice', // Slug menu
            'clws_access_getall_notice', // display function
        );
        add_submenu_page(
            'dashboard', // Slug menu parent
            'messages', // title page
            'Messages', // name menu
            'manage_options', // area supper admin and admin
            'messages', // Slug menu
            'clws_access_getall_messages', // display function
        );
        add_submenu_page(
            'dashboard', // Slug menu parent
            'Product', // title page
            'Products', // name menu
            'manage_options', // area supper admin and admin
            'product', // Slug menu
            'clws_access_product', // display function
        );
        add_submenu_page(
            'dashboard', // Slug menu parent
            'setting', // title page
            'Setting', // name menu
            'manage_options', // area supper admin and admin
            'setting', // Slug menu
            'clws_access_properties_loggin', // display function
        );
    }
});
add_action('init',function() {
    session_start();
});
////////////////////////////////////////////// dashboard //////////////////////////////////////////
function clws_access_dashboard() {
    if (!empty(get_option('cloodo_token'))) {
        echo "
            <script>
                setTimeout(window.onload = function() {
                    jQuery(document).find( '#login' ).remove();
                    var myIfr = window.frames['iframeclws'].contentWindow;
                    var val = myIfr.postMessage('".get_option('cloodo_token')."','".esc_url(CLWS_IFRAME_URL)."check-login');
                },3000)
            </script>";
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/dashboard.php'));
        return;
    } else {
        $emailadm = sanitize_text_field(get_option( 'admin_email'));
        $id = get_current_user_id();
        $user = get_userdata($id);
        $namesite = get_bloginfo();
        $user_login = sanitize_text_field($user->user_login);
        $user_email = sanitize_email($user->user_email);
        $company_name = (explode('.', $namesite))[0];
        if (isset($_POST['Register_quickly'])) {
            $pw = substr(md5(rand(0, 99999)), 0, 6);
            $arrs =[
                'method'=> 'POST',
                'body'=>[
                'company_name'=> $company_name,
                'email'=> $emailadm,
                'website' => $namesite,
                'password'=> $pw,
                'password_confirmation'=> $pw
                ],
                'timeout'=> 10,
                'redirection'=> 5,
                'blocking'=> true,
                'headers'=> [],
                'cookie'=> [],
            ];
            $res = wp_remote_request('https://erp.cloodo.com/api/v1/create-user',$arrs);
            if ( is_wp_error( $res ) ) {
                $_SESSION['error'] = $res->get_error_message();
            } else {
                $result = isset($res['body']) ? json_decode($res['body'], true) : 0;
                if(isset($result['status']) == 'success') {
                    ///////////////////////////////// register and login get token !
                    $arrs = [
                        'method'=> 'POST',
                        'body'=>['email'=>$emailadm,'password'=> $pw],
                        'timeout'=>100,
                        'redirection'=>5,
                        'blocking'=>true,
                        'headers'=>[],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login', $arrs);
                    if (isset($res['response']['code']) != 200) {
                        $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'];
                    } else {
                        $to = $emailadm;
                        $subject ='Thư Cám ơn và gửi Mật Khẩu cho bạn !';
                        $message =  "Chào bạn <b>{$user_login}</b><br> Mật khẩu của bạn là : {$pw}";
                        $headers = 'From:hoanle161996@gmail.com' . "\r\n" .
                        'Reply-To:hoanle161996@gmail.com' . "\r\n";
                        $sent = wp_mail($to, $subject, strip_tags($message), $headers);
                        $res = json_decode($res['body'], true);
                        $id_token = $res['data']['token'];
                        $_SESSION['token'] = $id_token;
                        update_option('cloodo_token', $id_token);
                        $dataoption[] = [
                            "token"=> $id_token,
                            "email"=> $emailadm,
                        ];
                        $dataoption = maybe_serialize($dataoption);
                        update_option('clws_info', $dataoption);
                        echo "
                            <script>
                                setTimeout(window.onload = function() {
                                    jQuery(document).find( '#login' ).remove();
                                    var myIfr = window.frames['iframeclws'].contentWindow;
                                    var val = myIfr.postMessage('".get_option('cloodo_token')."','".esc_url(CLWS_IFRAME_URL)."check-login');
                                },3000)
                            </script>";
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/dashboard.php'));
                        return;
                    }
                } else {
                    $_SESSION['error'] = 'The Accounts already exists or has not activated email, please try again !';
                }
            }
        }
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/dashboard.php'));
        return;
    }
}
/////////////////////////////////////////// work ///////////////////////////////////////////////////
function clws_access_getall_works() {
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-project.php'));
    return; 
}
///////////////////////////////////////////// leads ////////////////////////////////////////////
function clws_access_getall_leads() {
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));      
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-lead.php'));
    return;
}
///////////////////////////////////////////////// clients //////////////////////////////////////////////////////
function clws_access_getall_clients() {
    if ( class_exists( 'WooCommerce' ) ) { ///////////////////////////////// data all oders - woocommerce ///////////////////////////////////////////////
        $arrs = [
            'method' => 'GET',
            'timeout' => 10,
            'redirection' => 5,
            'blocking' => true,
            'cookie' => [],
            'headers' => [
                'X-requested-Width'=>'XMLHttpRequest',
                'Authorization'=>'Bearer '.sanitize_text_field(get_option('cloodo_token'))
            ],
            'body' => [
            ]
        ];
        $res = wp_remote_request('https://erp.cloodo.com/api/v1/client/?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}&offset=0', $arrs);
        if (is_wp_error($res)) {
            $_SESSION['error'] =  $res->get_error_message();
        } elseif ($res['response']['code'] != 200) {                   
            $_SESSION['error'] = 'view lead error!';                    
        } else {
            $arr = json_decode($res['body'], true);
            $totalSum = $arr['meta']['paging']['total'];
            $res = wp_remote_request('https://erp.cloodo.com/api/v1/client/?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}&offset=0&limit='.$totalSum, $arrs);
            $all_data = json_decode($res['body'],true);
            $orders = wc_get_orders([
                'limit'=> -1
            ]);
            $customArr = [];
            foreach( $all_data['data'] as $value) {
                $key = $value['email'];
                $customArr[] = $key;
            }
            foreach ($orders as $key => $clwsvalue) {
                $data = ($clwsvalue->get_data());
                if (!in_array($data['billing']['email'], $customArr)) {
                    $randPass = substr(md5(rand(0, 99999)), 0, 6);
                    $arrs = [
                        'method' => 'POST',
                        'timeout' => 10,
                        'redirection' => 5,
                        'blocking' => true,
                        'cookie' => [],
                        'headers' => [
                            'X-requested-Width'=>'XMLHttpRequest',
                            'Authorization'=>'Bearer '.sanitize_text_field(get_option('cloodo_token'))
                        ],
                        'body' => [
                            'name' => sanitize_text_field($data['billing']['first_name'].' '.$data['billing']['last_name']) ,
                            'email' => sanitize_email($data['billing']['email'])  ,
                            'password' => sanitize_text_field($randPass),
                            'mobile' => sanitize_text_field($data['billing']['phone']) ,
                            'client_detail' => [
                                'company_name'=> sanitize_text_field($data['billing']['company']),
                                'address'=> sanitize_text_field($data['billing']['address_1']),
                                'city'=> sanitize_text_field($data['billing']['city']),
                                'postal_code'=> sanitize_text_field($data['billing']['postcode']),
                                'shipping_address'=> sanitize_text_field($data['billing']['address_2']),
                            ]
                        ],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/client', $arrs);
                }
            }
        }
        // $tokenId = sanitize_text_field(get_option('cloodo_token'));
        // $args = [];
        // foreach ($orders as $valuenew) {
        //     $data = ($valuenew->get_data());
        //     $key = sanitize_text_field($data['billing']['email']);
        //     if (!isset($args[$key]['oders']) && !isset($args[$key]['sumtotal']) && !array_key_exists($key, $args)) {
        //         $args[$key] = $data;
        //         $args[$key]['oders'] = 1;
        //         $args[$key]['sumtotal'] = $data['total'];
        //     } else {
        //         $args[$key]['oders'] += 1;
        //         $args[$key]['sumtotal'] += $data['total'];
        //     }
        // }
        // // echo 'runn~';
        //     echo '<pre>';
        //     print_r($args);
        //     echo '</pre>';
        // foreach ($args as $key => $clwsvalue) {
        //     // echo 'runn~';
        //     // echo '<pre>';
        //     // var_dump($key,$clwsvalue);
        //     // echo '</pre>';
        //     $randPass = substr(md5(rand(0, 99999)), 0, 6);
        //     $arrs = [
        //         'method' => 'POST',
        //         'timeout' => 10,
        //         'redirection' => 5,
        //         'blocking' => true,
        //         'cookie' => [],
        //         'headers' => [
        //             'X-requested-Width'=>'XMLHttpRequest',
        //             'Authorization'=>'Bearer '.$tokenId,
        //         ],
        //         'body' => [
        //             'name' => sanitize_text_field($clwsvalue['billing']['first_name'].' '.$clwsvalue['billing']['last_name']) ,
        //             'email' => sanitize_email($key)  ,
        //             'password' => sanitize_text_field($randPass),
        //             'mobile' => sanitize_text_field($clwsvalue['billing']['phone']) ,
        //             'client_detail' => [
        //                 'company_name'=> sanitize_text_field($clwsvalue['billing']['company']),
        //                 'address'=> sanitize_text_field($clwsvalue['billing']['address_1']),
        //                 'city'=> sanitize_text_field($clwsvalue['billing']['city']),
        //                 'postal_code'=> sanitize_text_field($clwsvalue['billing']['postcode']),
        //                 'shipping_address'=> sanitize_text_field($clwsvalue['billing']['address_2']),
        //             ]
        //         ],
        //     ];
        //     $res = wp_remote_request('https://erp.cloodo.com/api/v1/client', $arrs);
        // }
    }
    
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-client.php'));
    return;
}
////////////////////////////////////////////////// notice //////////////////////////////////////////////////
function clws_access_getall_notice() {
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));      
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-notice.php'));
    return;
}
////////////////////////////////////////////////// messages //////////////////////////////////////////////////
function clws_access_getall_messages() {
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));      
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-mesages.php'));
    return;
}
////////////////////////////////////////////////// product //////////////////////////////////////////////////
function clws_access_product() {
    if ( class_exists( 'WooCommerce' ) ) {
        $arrs = [
            'method' => 'GET',
            'timeout' => 10,
            'redirection' => 5,
            'blocking' => true,
            'cookie' => [],
            'headers' => [
                'X-requested-Width'=>'XMLHttpRequest',
                'Authorization'=>'Bearer '.sanitize_text_field(get_option('cloodo_token'))
            ],
            'body' => [
            ]
        ];
        $res = wp_remote_request('https://erp.cloodo.com/api/v1/product/?fields=id,name,price,description,taxes,allow_purchase,category,hsn_sac_code&offset=0', $arrs);
        if (is_wp_error($res)) {
            $_SESSION['error'] =  $res->get_error_message();
        } elseif ($res['response']['code'] != 200) {                   
            $_SESSION['error'] = 'view lead error!';                    
        } else {
            $arr = json_decode($res['body'],true);
            $totalSum = $arr['meta']['paging']['total'];
            $res = wp_remote_request('https://erp.cloodo.com/api/v1/product/?fields=id,name,price,description,taxes,allow_purchase,category,hsn_sac_code&offset=0&limit='.$totalSum, $arrs);
            $all_data = json_decode($res['body'],true);
            $product = wc_get_products ([
                'limit' => -1
            ]);
            $customArr = [];
            foreach( $all_data['data'] as $value) {
                $key = $value['hsn_sac_code'];
                $customArr[] = $key;
            }
            foreach ($product as $clwsvalue) {
                $data = ($clwsvalue->get_data());
                echo '<pre>';
                print_r($data);
                echo '<hr>';
                echo '</pre>';
                if (!in_array($data['id'],$customArr)) {
                    $arrs = [
                        'method' => 'POST',
                        'timeout' => 10,
                        'redirection' => 10,
                        'blocking' => true,
                        'cookie' => [],
                        'headers' => [
                            'X-requested-Width'=>'XMLHttpRequest',
                            'Authorization'=>'Bearer '.sanitize_text_field(get_option('cloodo_token'))
                        ],
                        'body' => [
                            'name' => $data['name'] ,
                            'price' => $data['price'],
                            'hsn_sac_code' => $data['id'],
                            'description' => $data['short_description'],
                        ]
                    ];
                    $res = wp_remote_request(' https://erp.cloodo.com/api/v1/product', $arrs);
                }
            }
        }
    }
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));      
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-product.php'));
    return;
}
/////////////////////////////////////////////// ajax /////////////////////////////////////////////////////////////////

///////////////////////////////////////////////// setting - swap account //////////////////////////////////////////////////////
function clws_access_properties_loggin() {/////////// login and register //////////
    $emailadm = sanitize_text_field(get_option( 'admin_email'));
    $id = get_current_user_id();
    $user = get_userdata($id);
    $namesite = get_bloginfo();
    $user_login = sanitize_text_field($user->user_login);
    $user_email = sanitize_email($user->user_email);
    $company_name = (explode('.',$namesite))[0];
    // if (isset($_POST['save'])) {
    //     $email = sanitize_email($_POST['email']);
    //     $password = sanitize_text_field($_POST['password']);
    //     $tokenId = sanitize_text_field(get_option( 'cloodo_token' ));
    //     $result = sanitize_text_field(get_option( 'clws_info' ));
    //     $dataoption = maybe_unserialize( $result );
    //     foreach($dataoption as $arr){
    //         if ($email == $arr['email']) {
    //             $_SESSION['error'] = 'This account has been there !';
    //             require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    //             require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/setting.php'));
    //             return;
    //         }
    //     }
    //     if ($email && $password != '') {
    //         $arrs =[
    //             'method'=> 'POST',
    //             'body'=> [
    //                 'email'=> $email,
    //                 'password'=> $password
    //             ],
    //             'timeout'=> 10,
    //             'redirection'=> 5,
    //             'blocking'=> true,
    //             'headers'=> [],
    //             'cookie'=> [],
    //         ];
    //         $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login',$arrs);
    //         if ($res['response']['code'] != 200) {
    //             $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'].' - Incorrect account or password !';
    //         } else {
    //             $res = json_decode($res['body'],true);
    //             $id_token = $res['data']['token'];
    //             update_option( 'cloodo_token', $id_token);                              
    //             $token = sanitize_text_field(get_option('cloodo_token'));
    //             $_SESSION['token'] = $token;
    //             $result = sanitize_text_field(get_option( 'clws_info' ));
    //             $dataoption = maybe_unserialize( $result );
    //             $dataoption[] = [
    //                 "token"=> $id_token,
    //                 "email"=> $email
    //             ];
    //             $dataoption = maybe_serialize( $dataoption );
    //             update_option( 'clws_info', $dataoption);
    //             echo "
    //                 <script>
    //                     setTimeout(window.onload = function() {
    //                         jQuery(document).find( '#login' ).remove();
    //                         var myIfr = window.frames['iframeclws'].contentWindow;
    //                         var val = myIfr.postMessage('".get_option('cloodo_token')."','".esc_url(CLWS_IFRAME_URL)."check-login');
    //                     },3000)
    //                 </script>";
    //         } 
    //     } else {
    //         $_SESSION['error'] = 'User and Password do not empty !';
    //     }    
    //     require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    //     require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/setting.php'));
    //     return;
    // }
    // if (isset($_POST['register'])) {
    //     $company_name = sanitize_text_field($_POST['company_name']);
    //     $email = sanitize_email($_POST['email']);
    //     $password = sanitize_text_field($_POST['password']);
    //     if (empty(trim($company_name))|| empty(trim($email))|| empty(trim($password))) {
    //         $_SESSION['error'] = " Email or Password do not empty !";
    //         $error = sanitize_text_field($_SESSION['error']);
    //     } elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    //         $_SESSION['error'] = 'Incorrect email format !';
    //         $error = sanitize_text_field($_SESSION['error']);
    //     } else {
    //         $result = sanitize_text_field(get_option('clws_info'));
    //         $dataoption = maybe_unserialize($result);
    //         foreach ($dataoption as $arr) {
    //             if ($email == $arr['email']) {
    //                 $_SESSION['error'] = 'This account has been there !';
    //                 $error = sanitize_text_field($_SESSION['error']);
    //             }
    //         }
    //     }
    //     if (empty($error)) {
    //         if (isset($_POST['checkbox'])) {
    //             $arrs =[
    //                 'method'=> 'POST',
    //                 'body'=> [
    //                 'company_name'=> $company_name,
    //                 'email'=> $email,
    //                 'password'=> $password,
    //                 'password_confirmation'=> $password
    //                 ],
    //                 'timeout'=> 10,
    //                 'redirection'=> 5,
    //                 'blocking'=> true,
    //                 'headers'=> [],
    //                 'cookie'=> [],
    //             ];
    //             $res = wp_remote_request('https://erp.cloodo.com/api/v1/create-user',$arrs);
    //             if ( is_wp_error( $res ) ) {
    //                 $_SESSION['error'] = $res->get_error_message();
    //             } else {
    //                 $result = isset($res['body'])? json_decode($res['body'],true) : 0;
    //                 if (isset($result['status']) == 'success') {
    //                     $arrs = [
    //                         'method'=> 'POST',
    //                         'body'=>['email'=> $email,'password'=> $password],
    //                         'timeout'=> 10,
    //                         'redirection'=> 5,
    //                         'blocking'=> true,
    //                         'headers'=> [],
    //                         'cookie'=> [],
    //                     ];
    //                     $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login',$arrs);
    //                     if ($res['response']['code'] != 200) {
    //                     $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'].'- The Accounts already exists or has not activated email, please try again !';
    //                     } else {
    //                         $res = json_decode($res['body'],true);
    //                         $id_token = $res['data']['token'];
    //                         $_SESSION['token'] = $id_token;
    //                         update_option( 'cloodo_token', $id_token);
    //                         $result = sanitize_text_field(get_option( 'clws_info' ));
    //                         $dataoption = maybe_unserialize( $result );
    //                         $dataoption[] = ["token"=> $id_token,
    //                         "email"=> $email];
    //                         $dataoption = maybe_serialize( $dataoption );
    //                         update_option( 'clws_info', $dataoption);
    //                         // $_SESSION['success'] ='Thank you for signing up !';
    //                         echo "
    //                             <script>
    //                                 setTimeout(window.onload = function() {
    //                                     jQuery(document).find( '#login' ).remove();
    //                                     var valselect = jQuery('select[name=accountselect] option').filter(':selected').val();
    //                                     var myIfr = window.frames['iframeclws'].contentWindow;
    //                                     var val = myIfr.postMessage(valselect,'".esc_url(CLWS_IFRAME_URL)."check-login');
    //                                 },3000)
    //                             </script>";
    //                     }
    //                 } else {
    //                     $_SESSION['error'] = ' Undefined error, Please try again !';
    //                 }
    //             }
    //         } else {
    //             $_SESSION['error'] = 'Check Box do not empty ! ';
    //         }
    //     }
    // }
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/setting.php'));
}
/////////////////////////////////////////////////////////////// end /////////////////////////////////////////////////////////
