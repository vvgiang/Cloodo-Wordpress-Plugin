<?php
/**
 * Plugin Name:       Cloodo Work Suite
 * Plugin URI:        https://worksuite.cloodo.com/
 * Description:       Project management, trusted badge review
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Cloodo
 * Author URI:        https://cloodo.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cloodo-worksuite
 * Domain Path:       /languages
 */
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
function clws_add_menu_projects() {
    add_menu_page(
        'Setting', // title menu
        'Worksuite', // name menu
        'manage_options',// area supper admin and admin 
        'Setting', // Slug menu
        'clws_access_properties_loggin', // display function 
        'dashicons-businessman', // icon menu
        '7'
    );
    // if(!empty($_SESSION['token'])){
        add_submenu_page( 
            'Setting', // Slug menu parent
            'work', // title page
            'Work', // name menu
            'manage_options',// area supper admin and admin 
            'Work', // Slug menu
            'clws_access_getall_works', // display function 
        );
        add_submenu_page( 
            'Setting', // Slug menu parent
            'Leads', // title page
            'Leads', // name menu
            'manage_options',// area supper admin and admin 
            'Leads', // Slug menu
            'clws_access_getall_leads', // display function 
        );
        add_submenu_page( 
            'Setting', // Slug menu parent
            'Clients', // title page
            'Clients', // name menu
            'manage_options',// area supper admin and admin 
            'Clients', // Slug menu
            'clws_access_getall_clients', // display function 
        );
    // }
    if ( !wp_doing_ajax() ) {
        $extension = isset($_GET['page'])? sanitize_text_field($_GET['page']) : "";
        $allows = ['Setting', 'leads', 'Work','Clients'];
        if(in_array($extension, $allows)) {
            echo '<div id="loading"></div>';             
        }
    }
}
add_action('admin_menu', 'clws_add_menu_projects');
/////////////////////////////////////////// Work ///////////////////////////////////////////////////
function clws_access_getall_works() {
    session_start();
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-project.php'));
    return; 
}
///////////////////////////////////////////// Leads ////////////////////////////////////////////
function clws_access_getall_leads() {
    session_start();
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));      
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-lead.php'));
    return;
}
///////////////////////////////////////////////// Clients //////////////////////////////////////////////////////
function clws_access_getall_clients() {
    session_start();
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-client.php'));

}
////////////////////////////////////////////////ajax/////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////setting - swap account//////////////////////////////////////////////////////
// function clws_setting_loggin_access() {///////////switch accout////////////
//     session_start();
//     if(isset($_POST['Custom_registration'])){
//         $tokennew = sanitize_text_field($_POST['accountselect']);
//         $_SESSION['token']= $tokennew;
//         update_option('token',$tokennew);
//         // echo "<script>
//         // alert('ok');
//         // echo 'run';
//         // exit;
//         //     localStorage.test ='".$tokennew."';
//         // </script>";
//         wp_redirect(esc_url(admin_url('admin.php?page=lead')));
//         exit;
//     }
// }
// add_action('init', 'clws_setting_loggin_access');
function clws_access_properties_loggin() {///////////login and register//////////
    session_start();
    $emailadm = sanitize_text_field(get_option( 'admin_email'));
    $id = get_current_user_id();
    $user = get_userdata($id);
    $namesite = get_bloginfo();
    $user_login = sanitize_text_field($user->user_login);
    $user_email = sanitize_email($user->user_email);
    $company_name = (explode('.',$namesite))[0];
    if (isset($_POST['save'])) {
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $tokenId = sanitize_text_field(get_option( 'token' ));
        $result = sanitize_text_field(get_option( 'info' ));
        $dataoption = maybe_unserialize( $result );
        foreach($dataoption as $arr){
            if ($email == $arr['email']) {
                $_SESSION['error'] = 'This account has been there !';
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/setting.php'));
                return;
            }
        }
        if ($email && $password != '') {
            $arrs =[
                'method'=> 'POST',
                'body'=> [
                    'email'=> $email,
                    'password'=> $password
                ],
                'timeout'=> 10,
                'redirection'=> 5,
                'blocking'=> true,
                'headers'=> [],
                'cookie'=> [],
            ];
            $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login',$arrs);
            if ($res['response']['code'] != 200) {
                $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'].' - Incorrect account or password !';
            } else {
                $res = json_decode($res['body'],true);
                $id_token = $res['data']['token'];
                update_option( 'token', $id_token);                              
                $token = sanitize_text_field(get_option('token'));
                $_SESSION['token'] = $token;
                $result = sanitize_text_field(get_option( 'info' ));
                $dataoption = maybe_unserialize( $result );
                $dataoption[] = [
                    "token"=> $id_token,
                    "email"=> $email];
                $dataoption = maybe_serialize( $dataoption );
                update_option( 'info', $dataoption);
                $pageSize = 10;
                $pageNum = isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : '1';
                $start = ($pageNum-1)* $pageSize;
                $arrs =[
                    'method'=> 'GET',
                    'body'=> [],
                    'timeout'=> 10,
                    'redirection'=> 5,
                    'blocking'=> true,
                    'headers'=> [
                        'X-requested-Width' => 'XMLHttpRequest',
                        'Authorization' => 'Bearer '.$token,
                        'Content-Type' => 'application/json',
                    ],
                    'cookie'=> [],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}', $arrs);
                if (is_wp_error($res)) {
                    $_SESSION['error'] =  $res->get_error_message();
                } elseif ($res['response']['code'] != 200 && !empty($error)) {  
                    $_SESSION['error'] = 'Add token error !';
                    $error = sanitize_text_field($_SESSION['error']);                               
                } else {
                    echo'<style>
                    #loading {
                    display: none;}
                    </style>';            
                    $_SESSION['success'] = 'Login successfuly ! ';
                    $arr = json_decode($res['body'],true);
                    $totalSum = $arr['meta']['paging']['total'];
                    $pageSum = ceil($totalSum/$pageSize);
                    $around = 3;
                    $next = $pageNum + $around;
                    if ($next > $pageSum) {
                        $next = $pageSum;
                    }
                    $pre = $pageNum - $around;
                    if ($pre <= 1) $pre = 1;
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/details-lead.php'));
                    return;
                }
            } 
        } else {
            $_SESSION['error'] = 'User and Password do not empty !';
        }    
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    }
    if (isset($_POST['register'])) {
        $company_name = sanitize_text_field($_POST['company_name']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        if (empty(trim($company_name))|| empty(trim($email))|| empty(trim($password))) {
            $_SESSION['error'] = " Email or Password do not empty !";
            $error = sanitize_text_field($_SESSION['error']);
        } elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Incorrect email format !';
            $error = sanitize_text_field($_SESSION['error']);
        } else {
            $result = sanitize_text_field(get_option('info'));
            $dataoption = maybe_unserialize($result);
            foreach ($dataoption as $arr) {
                if ($email == $arr['email']) {
                    $_SESSION['error'] = 'This account has been there !';
                    $error = sanitize_text_field($_SESSION['error']);
                }
            }
        }
        if (empty($error)) {
            if (isset($_POST['checkbox'])) {
                $arrs =[
                    'method'=> 'POST',
                    'body'=> [
                    'company_name'=> $company_name,
                    'email'=> $email,
                    'password'=> $password,
                    'password_confirmation'=> $password
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
                    $result = isset($res['body'])? json_decode($res['body'],true) : 0;
                    if (isset($result['status']) == 'success') {
                        $arrs = [
                            'method'=> 'POST',
                            'body'=>['email'=> $email,'password'=> $password],
                            'timeout'=> 10,
                            'redirection'=> 5,
                            'blocking'=> true,
                            'headers'=> [],
                            'cookie'=> [],
                        ];
                        $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login',$arrs);
                        if ($res['response']['code'] != 200) {
                        $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'].'- The Accounts already exists or has not activated email, please try again !';
                        } else {
                            $res = json_decode($res['body'],true);
                            $id_token = $res['data']['token'];
                            $_SESSION['token'] = $id_token;
                            update_option( 'token', $id_token);
                            $result = sanitize_text_field(get_option( 'info' ));
                            $dataoption = maybe_unserialize( $result );
                            $dataoption[] = ["token"=> $id_token,
                            "email"=> $email];
                            $dataoption = maybe_serialize( $dataoption );
                            update_option( 'info', $dataoption);
                            $_SESSION['success'] ='Thank you for signing up !';
                        }
                    } else {
                        $_SESSION['error'] = ' Undefined error, Please try again !';
                    }
                }
            } else {
                $_SESSION['error'] = 'Check Box do not empty ! ';
            }
        }
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    }
    if (isset($_POST['Register_quickly'])) {
        $pw = substr(md5(rand(0, 99999)), 0, 6);
        $arrs =[
            'method'=> 'POST',
            'body'=>[
            'company_name'=> $company_name,
            'email'=> $emailadm,
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
                //////////////////// demo ////////////// register and login get token !
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
                    update_option('token', $id_token);
                    $dataoption[] = [
                        "token"=> $id_token,
                        "email"=> $emailadm,
                    ];
                    $dataoption = maybe_serialize($dataoption);
                    update_option('info', $dataoption);
                }
            } else {
                $_SESSION['error'] = 'The Accounts already exists or has not activated email, please try again !';
            }
        }
    }
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'clws-Page/setting.php'));
}
///////////////////////////////////////////////////////////////end/////////////////////////////////////////////////////////
