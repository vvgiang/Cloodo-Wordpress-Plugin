<?php
session_start();
/**
 * Plugin Name:       Cloodo Worksuite
 * Plugin URI:        https://worksuite.cloodo.com/
 * Description:       Project management, trusted badge review
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Cloodo
 * Author URI:        https://cloodo.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       cloodo-worksuite
 * Domain Path:       /languages
 */
//////////////////////////////////////////////////require////////////////////////////////////////////////////
require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/includes/includes.php'));
//////////////////////////////////////////////////cw_add_iframe///////////////////////////////////////////////// 
function cw_add_iframe(){
    $url= get_site_url();   
    $newurl = (explode("/",trim($url,"/")))[2] ;
    return '<iframe src="https://cloodo.com/trustscore/' . $newurl . '"'.'frameborder="0" width="auto" height="300px" scrolling="no" />';
}
add_shortcode( 'cloodo-badge', 'cw_add_iframe' );
////////////////////////////////////////////////project list///////////////////////////////////////////////////
function cw_add_menu_project(){
    add_menu_page(
            'CURD project', // title menu
            'cloodo-worksuite', // name menu
            'manage_options',// area supper admin and admin 
            'project_list', // Slug menu
            'cw_access_getall_project', // display function 
            'dashicons-businessman' // icon menu
    );
}
add_action('admin_menu', 'cw_add_menu_project');
function cw_crud_project(){
    function cw_access_getall_project(){ 
        if(isset( $_SESSION['token'])){//////////////token not empty////////////////////
            if(isset($_GET['view']) && $_GET['view']=='post'){////////////add view project/////////////////////////
                $pageSum=sanitize_text_field($_GET['pageSum']); 
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/add-project.php'));
                return;
            }
            if(isset($_GET['idadd'])){/////////////add project////////////////////////
                if(isset($_POST['submit'])){
                    $project_name = sanitize_text_field($_POST['project_name']);
                    $start_date = sanitize_text_field($_POST['start_date']);
                    $deadline = sanitize_text_field($_POST['deadline']);
                    $status = sanitize_text_field($_POST['status']);
                    $arrs =[
                        'method'=> 'POST',
                        'body'=>[
                            'project_name'=> $project_name,
                            'start_date'=> $start_date,
                            'deadline'=> $deadline,
                            'status'=> $status
                        ],
                        'timeout'=>5,
                        'redirection'=>5,
                        'blocking'=>true,
                        'headers'=>[
                            'X-requested-Width'=>'XMLHttpRequest',
                            'Authorization'=>'Bearer '.$_SESSION['token'],
                        ],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/project', $arrs);
                    if($res['response']['code'] != 200){
                            $_SESSION['error'] = 'add project error';  
                        }
                    else{                 
                            $_SESSION['success'] = 'add project successfuly ! ';
                            $arr = json_decode($res['body'],true);
                            $row =$arr['data'];
                    }
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));
                }
            }
            if(isset($_GET['view']) && $_GET['view']=='edit'&& isset($_GET['id'])){/////////////Get width id project////////////////////       
                $id = sanitize_text_field($_GET['id']);
                $pageNum= isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : "1"; 
                $arrs =[
                    'method'=> 'GET',
                    'body'=>[],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.$_SESSION['token'],
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/project/'.$id.'/?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client%7Bid,name%7D', $arrs);
                if($res['response']['code'] != 200){
                    $_SESSION['error'] = ' Get project error !';                       
                }    
                else{                       
                    $_SESSION['success'] = 'Get project successfuly ! ';
                    $arr = json_decode($res['body'],true);
                    $row =$arr['data'];
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));   
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/edit-project.php'));
                    return;
                }
            }
            if(isset($_GET['idput'])){  /////////////update project///////////////////
                if(isset($_POST['submit'])){           
                    $project_name = sanitize_text_field($_POST['project_name']);
                    $start_date = sanitize_text_field($_POST['start_date']);
                    $deadline = sanitize_text_field($_POST['deadline']);
                    $status = sanitize_text_field($_POST['status']);
                    $id = sanitize_text_field($_GET['idput']);
                    $arrs =[
                        'method'=> 'PUT',
                        'body'=>[
                        'project_name'=>$project_name,
                        'start_date'=> $start_date,
                        'deadline'=> $deadline,
                        'status'=> $status,
                        ],
                        'timeout'=>5,
                        'redirection'=>5,
                        'blocking'=>true,
                        'headers'=>[
                            'X-requested-Width'=>'XMLHttpRequest',
                            'Authorization'=>'Bearer '.$_SESSION['token'],
                        ],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/project/'.$id, $arrs);
                    if($res['response']['code'] != 200){
                        $_SESSION['error'] = 'update error ! ';          
                    }    
                    else{                    
                        $_SESSION['success'] = 'update successfuly ! ';
                    }
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));
                }
            }
            if(isset($_GET['iddel'])){////////////////delete project///////////////////////
                $id = sanitize_text_field($_GET['iddel']);
                $arr =[
                    'method'=>'DELETE',
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.$_SESSION['token'],
                        'Content-Type'=>'application/json'
                    ],
                    'body'=>[],
                    'timeout'=>'5',
                    'redirection'=>'5',
                    'blocking'=>true,
                    'cookie'=>[],
                ];
                $res = wp_remote_request('https://erp.cloodo.com/api/v1/project/'.$id,$arr);
                if($res['response']['code'] != 200){
                  $_SESSION['error'] ='delete error !';
                }else{
                  $_SESSION['success'] ='delete successfuly !';
                }
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));              
            }            
            if(!isset($_GET['pageNum'])){  /////////show all project pageNum=null//////////////////              
                $star = 0;
                $pageSize = 10;                   
                $pageNum = 1;
                $arrs =[
                    'method'=> 'GET',
                    'body'=>[],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.$_SESSION['token'],
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/project?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client{id,name}', $arrs); 
                if($res['response']['code'] != 200){                   
                    $_SESSION['error'] = 'view project error!';                    
                }    
                else{                    
                    $_SESSION['success'] = 'view project ';
                    $arr = json_decode($res['body'],true);
                    $totalSum = $arr['meta']['paging']['total'];
                    if($totalSum == '0'){
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/add-project.php'));
                        return;
                    }
                    $pageSum = ceil($totalSum/$pageSize);
                    $ofsetPageMax = ($pageSum-1) * $pageSize;
                    $resPageMax = wp_remote_get("https://erp.cloodo.com/api/v1/project?fields=id%2Cproject_name%2Cproject_summary%2Cnotes%2Cstart_date%2Cdeadline%2Cstatus%2Ccategory%2Cclient%7Bid%2Cname%7D&offset=".$ofsetPageMax, $arrs);
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
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));      
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/details-project.php'));
                return;
            }else{//////////////show all project pageNum=$_GET///////////////////////
                $pageSize = 10;                   
                $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : '1';
                $star = ($pageNum -1) * $pageSize;
                $arrs =[
                    'method'=> 'GET',
                    'body'=>[],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.$_SESSION['token'],
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get("https://erp.cloodo.com/api/v1/project?fields=id%2Cproject_name%2Cproject_summary%2Cnotes%2Cstart_date%2Cdeadline%2Cstatus%2Ccategory%2Cclient%7Bid%2Cname%7D&offset=".$star, $arrs);
                if($res['response']['code'] != 200){                       
                    $_SESSION['error'] = 'view project error';
                }
                else{
                    $_SESSION['success'] = 'view project';
                    $arr = json_decode($res['body'],true);
                    $totalSum = $arr['meta']['paging']['total'];
                    if($totalSum == '0'){
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/add-project.php'));
                        return;
                    }
                    $pageSum = ceil($totalSum/$pageSize);
                    $ofsetPageMax = ($pageSum-1) * $pageSize;
                    $resPageMax = wp_remote_get("https://erp.cloodo.com/api/v1/project?fields=id%2Cproject_name%2Cproject_summary%2Cnotes%2Cstart_date%2Cdeadline%2Cstatus%2Ccategory%2Cclient%7Bid%2Cname%7D&offset=".$ofsetPageMax, $arrs);
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
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/details-project.php'));
                }    
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));
                return;
            }
            
            
        }else{ /////////////////not token - show login form/////////////////////////////
            if(isset($_POST['save'])){
                $email = sanitize_email($_POST['email']);
                $password = sanitize_text_field($_POST['password']);
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
                    $_SESSION['error'] = 'User notfound !';           
                    }
                    else{
                        $res = json_decode($res['body'],true);
                        $id_token = $res['data']['token'];
                        update_option( 'token', $id_token);                              
                        $token = get_option('token');
                        $_SESSION['token']= $token;
                        $pageSize = 10;
                        $pageNum = isset($_GET['pageNum']) ? sanitize_text_field($_GET['pageNum']) : '1';
                        $star = ($pageNum-1)* $pageSize;
                        $arrs =[
                            'method'=> 'GET',
                            'body'=>[],
                            'timeout'=>5,
                            'redirection'=>5,
                            'blocking'=>true,
                            'headers'=>[
                                'X-requested-Width'=>'XMLHttpRequest',
                                'Authorization'=>'Bearer '.$_SESSION['token'],
                                'Content-Type'=>'application/json',
                            ],
                            'cookie'=>[],
                        ];
                        $res = wp_remote_get('https://erp.cloodo.com/api/v1/project?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client{id,name}', $arrs);
                        if($res['response']['code'] != 200){  
                            $_SESSION['error'] = 'add token error !';                                
                        }    
                        else{                
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
                            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));
                            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/details-project.php'));
                            return;
                        }
                    } 
                }else{
                    $_SESSION['success'] = 'User and Password do not empty !';
                }    
            }
            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/show-results.php'));
            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api/login-project.php'));
        }    
    }  
    if(isset($_GET['logout'])){
        unset($_SESSION['token']);
        $_SESSION['success'] = 'Logout successfuly ! ';
        wp_redirect(get_site_url().'/wp-admin/admin.php?page=project_list');
        exit;
    }
} 
add_action('init','cw_crud_project');
/////////////////////////////////////////////

