<?php
/**
 * Plugin Name:       Cloodo Work Suite
 * Plugin URI:        https://worksuite.cloodo.com/
 * Description:       Project management, trusted badge review
 * Version:           1.0.0
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
    return '<iframe src="' . esc_url('https://cloodo.com/trustscore/'.$newurl) . '"'.'frameborder="0" width="auto" height="300px" scrolling="no" />';
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
    if(!empty($_SESSION['token'])){
        add_submenu_page( 
            'Setting', // Slug menu parent
            'Crud Lead', // title page
            'Lead', // name menu
            'manage_options',// area supper admin and admin 
            'lead', // Slug menu
            'clws_access_getall_leads', // display function 
        );
        add_submenu_page( 
            'Setting', // Slug menu parent
            'Crud Project', // title page
            'Project', // name menu
            'manage_options',// area supper admin and admin 
            'project_list', // Slug menu
            'clws_access_getall_project', // display function 
        );
        add_submenu_page( 
            'Setting', // Slug menu parent
            'Client', // title page
            'Client', // name menu
            'manage_options',// area supper admin and admin 
            'Client', // Slug menu
            'clws_access_getall_client', // display function 
        );
    }
    if ( !wp_doing_ajax() ) {
        $extension = isset($_GET['page'])? sanitize_text_field($_GET['page']) : "";
        $allows = ['Setting', 'lead', 'project_list','Client'];
        if(in_array($extension, $allows)) {
            echo '<div id="loading"></div>';             
        }
    }
}
add_action('admin_menu', 'clws_add_menu_projects');
////////////////////////////////////////////process project///////////////////////////////////////////////////
function clws_access_getall_project() {
    session_start();
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/details-project.php'));
    return;    
}
///////////////////////////////////////////// process Lead////////////////////////////////////////////
function clws_access_getall_leads() {
    session_start();
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));      
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/details-lead.php'));
    return;
}
////////////////////////////////////////////////ajax/////////////////////////////////////////////////////////////////
// function clws_ajax_lead() {
//     if(isset($_GET['iddel'])){////////////////////////////////////////delete lead////////////////////////////////////
//         $id = sanitize_text_field($_GET['iddel']);
//         $arr =[
//             'method'=>'DELETE',
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json'
//             ],
//             'body'=>[],
//             'timeout'=>'5',
//             'redirection'=>'5',
//             'blocking'=>true,
//             'cookie'=>[],
//         ];
//         $res = wp_remote_request('https://erp.cloodo.com/api/v1/lead/'.$id,$arr);             
//     } 
//     if(!isset($_GET['pageNum'])){//////////////////////////////////show all lead pageNum=null///////////////////////////
//         $start = 0;
//         $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                   
//         $pageNum = 1;
//         $arrs =[
//             'method'=> 'GET',
//             'body'=>[],
//             'timeout'=>5,
//             'redirection'=>5,
//             'blocking'=>true,
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json',
//             ],
//             'cookie'=>[],
//         ];
//         $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offset='.$start.'&limit='.$pageSize, $arrs);
//     }else{//////////////show all lead pageNum=$_GET///////////////////////////////////////////////
//         $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                      
//         $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : 1;
//         $start = ($pageNum -1) * $pageSize;
//         $arrs =[
//             'method'=> 'GET',
//             'body'=>[],
//             'timeout'=>5,
//             'redirection'=>5,
//             'blocking'=>true,
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json',
//             ],
//             'cookie'=>[],
//         ];
//         $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offset='.$start.'&limit='.$pageSize, $arrs);
//     }
//     wp_send_json_success($res); // response json
//     die();// required   
// }
// add_action( 'wp_ajax_ajax_lead','clws_ajax_lead' );
// add_action( 'wp_ajax_nopriv_ajax_lead','clws_ajax_lead' );
// function clws_ajax_client() {
//     if(isset($_GET['idGet'])){////////////////////////////////////////Get one client////////////////////////////////////
//         $id = sanitize_text_field($_GET['idGet']);
//         $arr =[
//             'method'=>'GET',
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json'
//             ],
//             'body'=>[],
//             'timeout'=>'5',
//             'redirection'=>'5',
//             'blocking'=>true,
//             'cookie'=>[],
//         ];
//         $res = wp_remote_request('https://erp.cloodo.com/api/v1/client/'.$id.'/?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}',$arr);             
//     }elseif(isset($_GET['oders']) && $_GET['oders'] == 'detail'){
//         $orders = wc_get_orders([
//             'limit'=> -1
//         ]);
//         $tokenId = sanitize_text_field(get_option( 'token' ));
//         $res = [];
//         foreach ($orders as $valuenew) {
//             $data = ($valuenew->get_data());
//             $key = $data['billing']['email'];
//             if (!isset($res[$key]['oders']) && !isset($res[$key]['F'])) {
//                 $res[$key] = $data;
//                 $res[$key]['oders'] = 1;
//                 $res[$key]['sumtotal'] = $data['total'];
//                 $randPass = substr(md5(rand(0, 99999)), 0, 6);
//             } elseif (array_key_exists($key, $res)) {
//                 $res[$key]['oders'] += 1;
//                 $res[$key]['sumtotal'] += $data['total'];
//             }
//         }
//     }elseif(!isset($_GET['pageNum'])){/////////////////////////////show all client pageNum=null///////////////////////////
//         $start = 0;
//         $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                   
//         $pageNum = 1;
//         $arrs =[
//             'method'=> 'GET',
//             'body'=>[],
//             'timeout'=>5,
//             'redirection'=>5,
//             'blocking'=>true,
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json',
//             ],
//             'cookie'=>[],
//         ];
//         $res = wp_remote_get('https://erp.cloodo.com/api/v1/client?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}&offset='.$start.'&limit='.$pageSize, $arrs);
//     }else{//////////////show all lead pageNum=$_GET///////////////////////////////////////////////
//         $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                      
//         $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : 1;
//         $start = ($pageNum -1) * $pageSize;
//         $arrs =[
//             'method'=> 'GET',
//             'body'=>[],
//             'timeout'=>5,
//             'redirection'=>5,
//             'blocking'=>true,
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json',
//             ],
//             'cookie'=>[],
//         ];
//         $res = wp_remote_get('https://erp.cloodo.com/api/v1/client?fields=id,name,email,mobile,status,created_at,client_details{company_name,website,address,office_phone,city,state,country_id,postal_code,skype,linkedin,twitter,facebook,gst_number,shipping_address,note,email_notifications,category_id,sub_category_id,image}&offset='.$start.'&limit='.$pageSize, $arrs);
//     }
//     wp_send_json_success($res); // response json
//     die();// required   
// }
// add_action( 'wp_ajax_ajax_client','clws_ajax_client' );
// add_action( 'wp_ajax_nopriv_ajax_client','clws_ajax_client' );
// function clws_ajax_project() {
//     if(isset($_GET['iddel'])){////////////////////////////////////////delete project////////////////////////////////////
//         $id = sanitize_text_field($_GET['iddel']);
//         $arr =[
//             'method'=>'DELETE',
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json'
//             ],
//             'body'=>[],
//             'timeout'=>'5',
//             'redirection'=>'5',
//             'blocking'=>true,
//             'cookie'=>[],
//         ];
//         $res = wp_remote_request('https://erp.cloodo.com/api/v1/project/'.$id,$arr);             
//     } 
//     if(!isset($_GET['pageNum'])){//////////////////////////////////show all project pageNum=null///////////////////////////
//         $start = 0;
//         $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                   
//         $pageNum = 1;
//         $arrs =[
//             'method'=> 'GET',
//             'body'=>[],
//             'timeout'=>5,
//             'redirection'=>5,
//             'blocking'=>true,
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json',
//             ],
//             'cookie'=>[],
//         ];
//         $res = wp_remote_get('https://erp.cloodo.com/api/v1/project?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client{id,name}&offset='.$start.'&limit='.$pageSize, $arrs);
//     }else{//////////////show all lead pageNum=$_GET///////////////////////////////////////////////
//         $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                      
//         $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : 1;
//         $start = ($pageNum -1) * $pageSize;
//         $arrs =[
//             'method'=> 'GET',
//             'body'=>[],
//             'timeout'=>5,
//             'redirection'=>5,
//             'blocking'=>true,
//             'headers'=>[
//                 'X-requested-Width'=>'XMLHttpRequest',
//                 'Authorization'=>'Bearer '.sanitize_text_field(get_option('token')),
//                 'Content-Type'=>'application/json',
//             ],
//             'cookie'=>[],
//         ];
//         $res = wp_remote_get('https://erp.cloodo.com/api/v1/project?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client{id,name}&offset='.$start.'&limit='.$pageSize, $arrs);
//     }
//     wp_send_json_success($res); // response json
//     die();// required   
// }
// add_action( 'wp_ajax_ajax_project','clws_ajax_project' );
// add_action( 'wp_ajax_nopriv_ajax_project','clws_ajax_project' );
///////////////////////////////////////////////// Client //////////////////////////////////////////////////////
function clws_access_getall_client() {
    session_start();
    // if ( class_exists( 'WooCommerce' ) ) { /////////////////////////////////data all oders - woocommerce///////////////////////////////////////////////
    // } else {
    //     echo'<style>
    //                 #loading {
    //                 display: none;}
    //                 </style>';
    //     $_SESSION['error'] = 'Please active woocommerce and come back !';
    
    // }
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'Client/show-client.php'));

}
/////////////////////////////////////////////////setting - swap account//////////////////////////////////////////////////////
function clws_setting_loggin_access() {///////////switch accout////////////
    session_start();
    if(isset($_POST['Custom_registration'])){
        $tokennew = sanitize_text_field($_POST['accountselect']);
        $_SESSION['token']= $tokennew;
        update_option('token',$tokennew);
        // echo '<script>
        //     localStorage.accessToken = '.sanitize_text_field(get_option('token')).';
        // </script>';
        wp_redirect(esc_url(admin_url('admin.php?page=lead')));
        exit;
    }
}
add_action('init', 'clws_setting_loggin_access');
function clws_access_properties_loggin() {///////////login and register//////////
    session_start();
    $emailtest = sanitize_text_field(get_option( 'admin_email'));
    $id = get_current_user_id();
    $user = get_userdata($id);
    $namesite = get_bloginfo();
    $user_login = sanitize_text_field($user->user_login);
    $user_email = sanitize_email($user->user_email);
    $company_name = (explode('.',$namesite))[0];
    if(isset($_POST['save'])){
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $tokenId = sanitize_text_field(get_option( 'token' ));
        $result = sanitize_text_field(get_option( 'info' ));
        $dataoption = maybe_unserialize( $result );
        foreach($dataoption as $arr){
            if($email == $arr['email']){
                $_SESSION['error'] = 'This account has been there !';
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/setting.php'));
                return;
            }
        }
        if($email && $password != ''){
            $arrs =[
                'method'=> 'POST',
                'body'=>['email'=>$email,'password'=> $password],
                'timeout'=>5,
                'redirection'=>5,
                'blocking'=>true,
                'headers'=>[],
                'cookie'=>[],
            ];
            $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login',$arrs);
            if($res['response']['code'] != 200){
                $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'].' - Incorrect account or password !';
            }else{
                $res = json_decode($res['body'],true);
                $id_token = $res['data']['token'];
                update_option( 'token', $id_token);                              
                $token = sanitize_text_field(get_option('token'));
                $_SESSION['token']= $token;
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
                    'body'=>[],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.$token,
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}', $arrs);
                if (is_wp_error($res)) {
                    $_SESSION['error'] =  $res->get_error_message();
                }elseif($res['response']['code'] != 200 && !empty($error)){  
                    $_SESSION['error'] = 'Add token error !';
                    $error = sanitize_text_field($_SESSION['error']);                               
                }else{
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
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/details-lead.php'));
                    return;
                }
            } 
        }else{
            $_SESSION['error'] = 'User and Password do not empty !';
        }    
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
    }
    if(isset($_POST['register'])) {
        $company_name = sanitize_text_field($_POST['company_name']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        if(empty(trim($company_name))|| empty(trim($email))|| empty(trim($password))) {
            $_SESSION['error'] = " Email or Password do not empty !";
            $error = sanitize_text_field($_SESSION['error']);
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Incorrect email format !';
            $error = sanitize_text_field($_SESSION['error']);
        }else{
            $result = sanitize_text_field(get_option('info'));
            $dataoption = maybe_unserialize($result);
            foreach ($dataoption as $arr) {
                if ($email == $arr['email']) {
                    $_SESSION['error'] = 'This account has been there !';
                    $error = sanitize_text_field($_SESSION['error']);
                }
            }
        }
        if(empty($error)) {
            if(isset($_POST['checkbox'])) {
                $arrs =[
                    'method'=> 'POST',
                    'body'=>[
                    'company_name'=>$company_name,
                    'email'=> $email,
                    'password'=>$password,
                    'password_confirmation'=>$password
                    ],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[],
                    'cookie'=>[],
                ];
                $res = wp_remote_request('https://erp.cloodo.com/api/v1/create-user',$arrs);
                if( is_wp_error( $res ) ) {
                    $_SESSION['error'] = $res->get_error_message();
                }else{
                    $result = isset($res['body'])? json_decode($res['body'],true) : 0;
                    if(isset($result['status']) == 'success'){
                        $arrs = [
                            'method'=> 'POST',
                            'body'=>['email'=>$email,'password'=> $password],
                            'timeout'=>5,
                            'redirection'=>5,
                            'blocking'=>true,
                            'headers'=>[],
                            'cookie'=>[],
                        ];
                        $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login',$arrs);
                        if($res['response']['code'] != 200){
                        $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'].'- The Accounts already exists or has not activated email, please try again !';
                        }else{
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
                    }else{
                        $_SESSION['error'] = ' Undefined error, Please try again !';
                    }
                }
            }else{
                $_SESSION['error'] = 'Check Box do not empty ! ';
            }
        }
        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
    }
    if(isset($_POST['Register_quickly'])) {
        $pw = substr(md5(rand(0, 99999)), 0, 6);
        $arrs =[
            'method'=> 'POST',
            'body'=>[
            'company_name'=>$company_name,
            'email'=> $emailtest,
            'password'=>$pw,
            'password_confirmation'=>$pw
            ],
            'timeout'=>5,
            'redirection'=>5,
            'blocking'=>true,
            'headers'=>[],
            'cookie'=>[],
        ];
        $res = wp_remote_request('https://erp.cloodo.com/api/v1/create-user',$arrs);
        if( is_wp_error( $res ) ) {
            $_SESSION['error'] = $res->get_error_message();
        }else{
            $result = isset($res['body']) ? json_decode($res['body'], true) : 0;
            if(isset($result['status']) == 'success') {
                //////////////////// demo////////////// register and login get token !
                $arrs = [
                    'method'=> 'POST',
                    'body'=>['email'=>$emailtest,'password'=> $pw],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[],
                    'cookie'=>[],
                ];
                $res = wp_remote_request('https://erp.cloodo.com/api/v1/auth/login', $arrs);
                if (isset($res['response']['code']) != 200) {
                    $_SESSION['error'] = $res['response']['code'].' '.$res['response']['message'];
                } else {
                    $to = $emailtest;
                    $subject ='Thư Cám ơn và gửi Mật Khẩu cho bạn !';
                    $message =  "Chào bạn <b>{$user_login}</b><br> Mật khẩu của bạn là : {$pw}";
                    $headers = 'From:hoanle161996@gmail.com' . "\r\n" .
                    'Reply-To:hoanle161996@gmail.com' . "\r\n";
                    $sent = wp_mail($to, $subject, strip_tags($message), $headers);
                    $res = json_decode($res['body'], true);
                    $id_token = $res['data']['token'];
                    $_SESSION['token']= $id_token;
                    update_option('token', $id_token);
                    $result = sanitize_text_field(get_option('info'));
                    $dataoption = maybe_unserialize($result);
                    $dataoption[] = ["token"=> $id_token,
                    "email"=> $emailtest];
                    if(count($dataoption) == 1){
                        $dataoption = maybe_serialize($dataoption);
                        update_option('info', $dataoption);
                        ////////////////////
                        $start = 0;
                        $pageSize = 10;                   
                        $pageNum = 1;
                        $token = sanitize_text_field(get_option('token'));
                        $arrs =[
                            'method'=> 'GET',
                            'body'=>[],
                            'timeout'=>5,
                            'redirection'=>5,
                            'blocking'=>true,
                            'headers'=>[
                                'X-requested-Width'=>'XMLHttpRequest',
                                'Authorization'=>'Bearer '.$token,
                                'Content-Type'=>'application/json',
                            ],
                            'cookie'=>[],
                        ];
                        $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}', $arrs);
                        if (is_wp_error($res)) {
                            $_SESSION['error'] =  $res->get_error_message();
                        }elseif($res['response']['code'] != 200){                   
                            $_SESSION['error'] = 'view lead error!';                    
                        }else{
                            echo'<style>
                                #loading {
                                display: none;}
                                </style>';            
                            $_SESSION['success'] = 'view lead successfuly';
                            $_SESSION['token']= $token;
                            $arr = json_decode($res['body'],true);
                            $totalSum = $arr['meta']['paging']['total'];
                            if($totalSum == '0'){
                                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/add-lead.php'));
                                return;
                            }
                            $pageSum = (ceil($totalSum/$pageSize)) > 0 ? ceil($totalSum/$pageSize): 1;
                            $ofsetPageMax = ($pageSum-1) * $pageSize;
                            $resPageMax = wp_remote_get("https://erp.cloodo.com/api/v1/lead?offset=".$ofsetPageMax, $arrs);
                            $arr2 = json_decode($resPageMax['body'],true);
                            if(count($arr2['data'])=='10'){
                                $nextpage = $pageSum + 1;
                            }else{
                                $nextpage = $pageSum;
                            }
                            $around = 3;
                            $next = $pageNum + $around;
                            if ($next > $pageSum) {
                                $next = $pageSum;
                            }
                            $pre = $pageNum - $around;
                            if ($pre <= 1) $pre = 1;
                        }
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));      
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/details-lead.php'));
                        return;
                    }
                    $dataoption = maybe_serialize($dataoption);
                    update_option('info', $dataoption);
                }
            } else {
                $_SESSION['error'] = 'The Accounts already exists or has not activated email, please try again !';
            }
        }
    }
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/setting.php'));
}
///////////////////////////////////////////////////////////////end/////////////////////////////////////////////////////////
