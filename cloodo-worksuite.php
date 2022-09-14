<?php
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
if(isset($_GET['page'])&& $_GET['page'] == 'project_list'){
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'includes/includes-project.php'));
}else if(isset($_GET['page'])&& $_GET['page']== 'lead'){
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'includes/includes-lead.php'));
}else{
    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'includes/includes-lead.php'));
}
//////////////////////////////////////////////////clws_add_iframe///////////////////////////////////////////////// 
function clws_add_iframe()
{
    $url= get_site_url();   
    $newurl = (explode("/",trim($url,"/")))[2] ;
    return '<iframe src="https://cloodo.com/trustscore/' . $newurl . '"'.'frameborder="0" width="auto" height="300px" scrolling="no" />';
}
add_shortcode( 'cloodo-badge', 'clws_add_iframe' );
////////////////////////////////////////////////process project///////////////////////////////////////////////////
function clws_add_menu_projects()
{
session_start();
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
    }
    if ( !wp_doing_ajax() ) {
        $extension = isset($_GET['page'])? sanitize_text_field($_GET['page']) : "";
        $allows = ['Setting', 'lead', 'project_list'];
        if(in_array($extension, $allows)) {
            echo '<div id="loading"></div>';             
        }
    }
}
add_action('admin_menu', 'clws_add_menu_projects');

function clws_crud_project() {
    function clws_access_getall_project() { 
        if(isset( $_SESSION['token'])){//////////////token not empty////////////////////
            if(isset($_GET['view']) && $_GET['view']=='post'){////////////add view project/////////////////////////
                echo'<style>
                        #loading {
                        display: none;}
                        </style>';
                $pageSum = sanitize_text_field($_GET['pageSum']); 
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/add-project.php'));
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
                            'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
                        ],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/project', $arrs);
                    if($res['response']['code'] != 200){
                        $_SESSION['error'] = 'add project error';  
                        }
                    else{                 
                        echo'<style>
                        #loading {
                        display: none;}
                        </style>';     
                        $_SESSION['success'] = 'add project successfuly ! ';
                        $arr = json_decode($res['body'],true);
                        $row =$arr['data'];
                    }
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
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
                        'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/project/'.$id.'/?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client%7Bid,name%7D', $arrs);
                if($res['response']['code'] != 200){
                    $_SESSION['error'] = ' Get project error !';                       
                }    
                else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>';                        
                    $_SESSION['success'] = 'Get project successfuly ! ';
                    $arr = json_decode($res['body'],true);
                    $row =$arr['data'];
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));   
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/edit-project.php'));
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
                            'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
                        ],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/project/'.$id, $arrs);
                    if($res['response']['code'] != 200){
                        $_SESSION['error'] = 'update error ! ';          
                    }    
                    else{
                        echo'<style>
                        #loading {
                        display: none;}
                        </style>';                    
                        $_SESSION['success'] = 'update successfuly ! ';
                    }
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
                }
            }
            if(isset($_GET['iddel'])){////////////////delete project///////////////////////
                $id = sanitize_text_field($_GET['iddel']);
                $arr =[
                    'method'=>'DELETE',
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
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
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>'; 
                    $_SESSION['success'] ='delete successfuly !';
                }
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));              
            }
            if(!isset($_GET['pageNum'])){  /////////show all project pageNum=null//////////////////
                $start = 0;
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
                        'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/project?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client{id,name}', $arrs); 
                if($res['response']['code'] != 200){                   
                    $_SESSION['error'] = 'view project error!';                    
                }else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>';                    
                    $_SESSION['success'] = 'view project ';
                    $arr = json_decode($res['body'],true);
                    $totalSum = $arr['meta']['paging']['total'];
                    if($totalSum == '0'){
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/add-project.php'));
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
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));      
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/details-project.php'));
                return;
            }else{//////////////show all project pageNum=$_GET///////////////////////
                $pageSize = 10;                   
                $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : '1';
                $start = ($pageNum -1) * $pageSize;
                $arrs =[
                    'method'=> 'GET',
                    'body'=>[],
                    'timeout'=>5,
                    'redirection'=>5,
                    'blocking'=>true,
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get("https://erp.cloodo.com/api/v1/project?fields=id%2Cproject_name%2Cproject_summary%2Cnotes%2Cstart_date%2Cdeadline%2Cstatus%2Ccategory%2Cclient%7Bid%2Cname%7D&offset=".$start, $arrs);
                if($res['response']['code'] != 200){                       
                    $_SESSION['error'] = 'view project error';
                }else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>'; 
                    $_SESSION['success'] = 'view project';
                    $arr = json_decode($res['body'],true);
                    $totalSum = $arr['meta']['paging']['total'];
                    if($totalSum == '0'){
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/add-project.php'));
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
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/details-project.php'));
                }    
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
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
                        $start = ($pageNum-1)* $pageSize;
                        $arrs =[
                            'method'=> 'GET',
                            'body'=>[],
                            'timeout'=>5,
                            'redirection'=>5,
                            'blocking'=>true,
                            'headers'=>[
                                'X-requested-Width'=>'XMLHttpRequest',
                                'Authorization'=>'Bearer '.sanitize_text_field($_SESSION['token']),
                                'Content-Type'=>'application/json',
                            ],
                            'cookie'=>[],
                        ];
                        $res = wp_remote_get('https://erp.cloodo.com/api/v1/project?fields=id,project_name,project_summary,notes,start_date,deadline,status,category,client{id,name}', $arrs);
                        if($res['response']['code'] != 200){  
                            $_SESSION['error'] = 'add token error !';                                
                        }    
                        else{
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
                            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
                            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/details-project.php'));
                            return;
                        }
                    } 
                }else{
                    $_SESSION['error'] = 'User and Password do not empty !';
                }    
            }
            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/show-results.php'));
            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-project/login-project.php'));
        }     
    }
    if(isset($_GET['logout']) && $_GET['logout']=='project'){
        unset($_SESSION['token']);
        $_SESSION['success'] = 'Logout successfuly ! ';
        wp_redirect(get_site_url().'/wp-admin/admin.php?page=Setting');
        exit;
    }
} 
add_action('init','clws_crud_project');
///////////////////////////////////////////// process Lead////////////////////////////////////////////
function clws_crud_lead() {
session_start();
    function clws_access_getall_leads() {
        if(isset($_SESSION['token'])){//////////////token not empty////////////////////
            if(isset($_GET['view']) && $_GET['view']=='post'){////////////add view lead/////////////////////////
                echo'<style>
                        #loading {
                        display: none;}
                        </style>';
                $pageSum = sanitize_text_field($_GET['pageSum']); 
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/add-lead.php'));
                return;
            }
            if(isset($_GET['idadd'])){/////////////add lead////////////////////////
                if(isset($_POST['submit'])){
                    $company_name = sanitize_text_field($_POST['company_name']);
                    $value = sanitize_text_field($_POST['value']);
                    $client_name = sanitize_text_field($_POST['client_name']);
                    $client_email = sanitize_text_field($_POST['client_email']);
                    $next_follow_up = sanitize_text_field($_POST['next_follow_up']);
                    $token = get_option('token');
                    $arrs =[
                        'method'=> 'POST',
                        'body'=>[
                        'company_name'=> $company_name,
                        'value'=> $value,
                        'client_name'=> $client_name,
                        'client_email'=> $client_email,
                        'next_follow_up'=> $next_follow_up
                        ],
                        'timeout'=>5,
                        'redirection'=>5,
                        'blocking'=>true,
                        'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.$token,
                        ],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/lead', $arrs);
                    if($res['response']['code'] != 200){
                        $_SESSION['error'] = 'add lead error';  
                    }else{ 
                        echo'<style>
                        #loading {
                        display: none;}
                        </style>';                 
                        $_SESSION['success'] = 'add lead successfuly ! ';
                        $arr = json_decode($res['body'],true);
                        $row =$arr['data'];
                    }
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
                }
            }
            if(isset($_GET['view']) && $_GET['view']=='edit'&& isset($_GET['id'])){/////////////Get width id lead////////////////////       
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
                        'Authorization'=>'Bearer '.get_option('token'),
                        'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/'.$id.'/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}', $arrs);
                if(is_wp_error($res)){
                    $_SESSION['error'] =  $res->get_error_message();
                }elseif($res['response']['code'] != 200){
                    $_SESSION['error'] = ' Get lead error !';                       
                }else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>';                      
                    $_SESSION['success'] = 'Get lead successfuly ! ';
                    $arr = json_decode($res['body'],true);
                    $row = $arr['data'];
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));   
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/edit-lead.php'));
                    return;
                }
            }
            if(isset($_GET['idput'])){  /////////////update lead///////////////////
                if(isset($_POST['submit'])){         
                    $company_name = sanitize_text_field($_POST['company_name']);
                    $value = sanitize_text_field($_POST['value']);
                    $client_name = sanitize_text_field($_POST['client_name']);
                    $client_email = sanitize_text_field($_POST['client_email']);
                    $next_follow_up = sanitize_text_field($_POST['next_follow_up']);
                    $id = sanitize_text_field($_GET['idput']);
                    $arrs =[
                        'method'=> 'PUT',
                        'body'=>[
                        'company_name'=>$company_name,
                        'value'=> $value,
                        'client_name'=> $client_name,
                        'client_email'=> $client_email,
                        'next_follow_up'=> $next_follow_up,
                        ],
                        'timeout'=>5,
                        'redirection'=>5,
                        'blocking'=>true,
                        'headers'=>[
                            'X-requested-Width'=>'XMLHttpRequest',
                            'Authorization'=>'Bearer '.get_option('token'),
                        ],
                        'cookie'=>[],
                    ];
                    $res = wp_remote_request('https://erp.cloodo.com/api/v1/lead/'.$id, $arrs);
                    if($res['response']['code'] != 200){
                        $_SESSION['error'] = 'update error ! ';          
                    }    
                    else{
                        echo'<style>
                        #loading {
                        display: none;}
                        </style>';                    
                        $_SESSION['success'] = 'update successfuly ! ';
                    }
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
                }
            }
            if(isset($_GET['iddel'])){////////////////delete lead///////////////////////
                $id = sanitize_text_field($_GET['iddel']);
                $arr =[
                    'method'=>'DELETE',
                    'headers'=>[
                        'X-requested-Width'=>'XMLHttpRequest',
                        'Authorization'=>'Bearer '.get_option('token'),
                        'Content-Type'=>'application/json'
                    ],
                    'body'=>[],
                    'timeout'=>'5',
                    'redirection'=>'5',
                    'blocking'=>true,
                    'cookie'=>[],
                ];
                $res = wp_remote_request('https://erp.cloodo.com/api/v1/lead/'.$id,$arr);
                if($res['response']['code'] != 200){
                    $_SESSION['error'] ='delete error !';
                }else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>'; 
                    $_SESSION['success'] ='delete successfuly !';
                }
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));              
            }           
            if(!isset($_GET['pageNum'])){  /////////show all lead pageNum=null//////////////////
                
                $start = 0;
                $pageSize = 10;                   
                $pageNum = 1;
                $token = get_option('token');
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
                if($res['response']['code'] != 200){                   
                    $_SESSION['error'] = 'view lead error!';                    
                }    
                else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>';                    
                    $_SESSION['success'] = 'view lead successfuly ';
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
            }else{//////////////show all lead pageNum=$_GET///////////////////////
                $pageSize = 10;                   
                $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : '1';
                $start = ($pageNum -1) * $pageSize;
                $token = get_option('token');
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
                $res = wp_remote_get("https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offset=".$start, $arrs);
                if($res['response']['code'] != 200){                       
                    $_SESSION['error'] = 'view lead error';
                }
                else{
                    echo'<style>
                        #loading {
                        display: none;}
                        </style>'; 
                    $_SESSION['success'] = 'view lead successfuly ';
                    $_SESSION['token']= $token;
                    $arr = json_decode($res['body'],true);
                    $totalSum = $arr['meta']['paging']['total'];
                    if($totalSum == '0'){
                        require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/add-lead.php'));
                        return;
                    }
                    $pageSum = ceil($totalSum/$pageSize);
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
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
                    require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/details-lead.php'));
                }    
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
                return;
            }  
        }else{ /////////////////not token - show login form/////////////////////////////
            $id = get_current_user_id();
            $user = get_userdata($id);
            $user_login = sanitize_text_field($user->user_login);
            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/show-results.php'));
            require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/setting.php'));
            return;
        }
    }
    if(isset($_GET['logout']) && $_GET['logout']=='lead'){
        unset($_SESSION['token']);
        echo'<style>
                        #loading {
                        display: none;}
                        </style>'; 
        $_SESSION['success'] = 'Logout successfuly ! ';
        wp_redirect(get_site_url().'/wp-admin/admin.php?page=Setting');
        exit;
    }
    if(isset($_GET['DeleteAcc']) && sanitize_text_field($_GET['DeleteAcc'])=='lead'){
        unset($_SESSION['token']);
        echo'<style>
                        #loading {
                        display: none;}
                        </style>'; 
        $_SESSION['success'] = 'Delete account successfuly ! ';
        $id_token = get_option('token');
        $result = get_option('info');
        $dataoption = maybe_unserialize( $result );
        foreach($dataoption as $key => $value){
            if($id_token == $value['token'])
            {
                if(count($dataoption) == 1 ) {
                    unset($_SESSION['success']);
                    $_SESSION['error'] = 'can\'t delete last account ';
                    continue;
                }
                unset($dataoption[$key]);
            }
        }
        $dataoption = maybe_serialize( $dataoption );
        update_option( 'info', $dataoption);
        wp_redirect(get_site_url().'/wp-admin/admin.php?page=Setting');
        exit;
    }
} 
add_action('init','clws_crud_lead');
////////////////////////////////////////////////ajax/////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_ajax_demo','clws_ajax_ajax_demo_func' );
add_action( 'wp_ajax_nopriv_ajax_demo','clws_ajax_ajax_demo_func' );
function clws_ajax_ajax_demo_func()
{
    if(isset($_GET['iddel'])){////////////////////////////////////////delete lead////////////////////////////////////
        $id = sanitize_text_field($_GET['iddel']);
        $arr =[
            'method'=>'DELETE',
            'headers'=>[
                'X-requested-Width'=>'XMLHttpRequest',
                'Authorization'=>'Bearer '.get_option('token'),
                'Content-Type'=>'application/json'
            ],
            'body'=>[],
            'timeout'=>'5',
            'redirection'=>'5',
            'blocking'=>true,
            'cookie'=>[],
        ];
        $res = wp_remote_request('https://erp.cloodo.com/api/v1/lead/'.$id,$arr);             
    } 
    if(!isset($_GET['pageNum'])){//////////////////////////////////show all lead pageNum=null///////////////////////////
        $start = 0;
        $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                   
        $pageNum = 1;
        $arrs =[
            'method'=> 'GET',
            'body'=>[],
            'timeout'=>5,
            'redirection'=>5,
            'blocking'=>true,
            'headers'=>[
                'X-requested-Width'=>'XMLHttpRequest',
                'Authorization'=>'Bearer '.get_option('token'),
                'Content-Type'=>'application/json',
            ],
            'cookie'=>[],
        ];
        $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offset='.$start.'&limit='.$pageSize, $arrs);
    }else{//////////////show all lead pageNum=$_GET///////////////////////////////////////////////
        $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                      
        $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : 1;
        $start = ($pageNum -1) * $pageSize;
        $arrs =[
            'method'=> 'GET',
            'body'=>[],
            'timeout'=>5,
            'redirection'=>5,
            'blocking'=>true,
            'headers'=>[
                'X-requested-Width'=>'XMLHttpRequest',
                'Authorization'=>'Bearer '.get_option('token'),
                'Content-Type'=>'application/json',
            ],
            'cookie'=>[],
        ];
        $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offset='.$start.'&limit='.$pageSize, $arrs);
    }
    wp_send_json_success($res); // response json
    die();// required   
}
/////////////////////////////////////////////////setting - swap account//////////////////////////////////////////////////////
function clws_setting_loggin_access() {
    function clws_access_properties_loggin() {
        $emailtest = get_option( 'admin_email');
        $id = get_current_user_id();
        $user = get_userdata($id);
        $namesite = get_bloginfo();
        $user_login = sanitize_text_field($user->user_login);
        $user_email = sanitize_email($user->user_email);
        $company_name = (explode('.',$namesite))[0];
        if(isset($_POST['save'])){
            $email = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);
            $tokenId = get_option( 'token' );
            $result = get_option( 'info' );
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
                    $token = get_option('token');
                    $_SESSION['token']= $token;
                    $result = get_option( 'info' );
                    $dataoption = maybe_unserialize( $result );
                    $dataoption[] = ["token"=> $id_token,
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
                    if($res['response']['code'] != 200 && !empty($error)){  
                        $_SESSION['error'] = 'Add token error !';
                        $error = $_SESSION['error'];                               
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
                $error = $_SESSION['error'];
            }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Incorrect email format !';
                $error = $_SESSION['error'];
            }else{
                $result = get_option('info');
                $dataoption = maybe_unserialize($result);
                foreach ($dataoption as $arr) {
                    if ($email == $arr['email']) {
                        $_SESSION['error'] = 'This account has been there !';
                        $error = $_SESSION['error'];
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
                            $error = $_SESSION['error'];
                            }else{
                                $res = json_decode($res['body'],true);
                                $id_token = $res['data']['token'];
                                $_SESSION['token'] = $id_token;
                                update_option( 'token', $id_token);
                                $result = get_option( 'info' );
                                $dataoption = maybe_unserialize( $result );
                                $dataoption[] = ["token"=> $id_token,
                                "email"=> $email];
                                $dataoption = maybe_serialize( $dataoption );
                                update_option( 'info', $dataoption);
                                $_SESSION['success'] ='Thank you for signing up !';
                                $success = $_SESSION['success'];
                            }
                        }else{
                            $_SESSION['error'] = ' Undefined error';
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
                        $result = get_option('info');
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
                            $token = get_option('token');
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
                            if($res['response']['code'] != 200){                   
                                $_SESSION['error'] = 'view lead error!';                    
                            }    
                            else{
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
    if(isset($_POST['Custom_registration'])){
        $tokennew = sanitize_text_field($_POST['accountselect']);
        $_SESSION['token']= $tokennew;
        update_option('token',$tokennew);
        wp_redirect(get_site_url().'/wp-admin/admin.php?page=lead');
        exit;
    }
    // unset($_SESSION['token']);
    // delete_option( 'token' );
    // delete_option( 'info' );
}
add_action('init', 'clws_setting_loggin_access');
