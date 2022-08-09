<?php
session_start();
/**
 * Plugin Name:       Call API Wordpress
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       CRUD call api test
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            hoanle2
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
//////////////////////////////////////menu get token/////////////////////////
add_action('admin_menu', 'add_submenu_getToken');
function add_submenu_getToken(){
    add_menu_page(
        'Login', // Tiêu đề của menu
        'Login get API', // Tên của menu
        'manage_options',// Vùng truy cập, giá trị này có ý nghĩa chỉ có supper admin và admin đc dùng
        'Get_token', // Slug của menu
        'access_menu_options' // Hàm callback hiển thị nội dung của menu
    );
}
add_action( 'admin_init', 'access_menu' );
function access_menu(){
    function access_menu_options(){
        if(isset($_POST['save'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
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
                    $_SESSION['success'] = 'Get token : ';
                }       
                require_once ('showresults.php');
            }           
        }
        require_once ('theme.php');
    }
}
////////////////////////////////////////////////project list///////////////////////////////////////////////////

function add_submenu_project(){
    add_menu_page(
            'CURD project', // Tiêu đề của menu
            'CRUD project', // Tên của menu
            'manage_options',// Vùng truy cập, giá trị này có ý nghĩa chỉ có supper admin và admin đc dùng
            'project_list', // Slug của menu
            'access_getAll' // Hàm callback hiển thị nội dung của menu
    );
}
add_action('admin_menu', 'add_submenu_project');
function headerlocation(){
    function access_getAll(){ 
        if(isset( $_SESSION['token'])){//////////////token-not empty////////////////////
            if(isset($_GET['view']) && $_GET['view']=='post'){////////////add view project///////////////////////// 
                require_once ('addnew.php');
                return;
            }
            if(isset($_GET['idadd'])){/////////////add project////////////////////////
                if(isset($_POST['submit'])){
                    $project_name = $_POST['project_name'];
                    $start_date = $_POST['start_date'];
                    $deadline = $_POST['deadline'];
                    $status = $_POST['status'];
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
                    require_once ('showresults.php');
                }
            }
            if(isset($_GET['view']) && $_GET['view']=='edit'&& isset($_GET['id'])){/////////////Get width id project////////////////////       
                $id = $_GET['id'];
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
                    require_once ('showresults.php');   
                    // require_once ('edit.php');
                    ?>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />
                    <form action="<?php echo get_site_url() ?>/wp-admin/admin.php?page=project_list&idput=<?php echo $row['id'] ?>" method="POST">
                        <div class="container ">
                                <div class="row">
                                            <div class="col-md-5">
                                            <h2>EDIT PROJECT</h2>
                                                    <div class="form-group">
                                                                <label>Projec_name</label>
                                                                <input type="text" name="project_name" value="<?php echo $row['project_name']?>" class="form-control" placeholder="projecname" required name="project_name">
                                                    </div>
                                                    <div class="form-group">
                                                                <label>start_date</label>
                                                                <input type="date" name="start_date" value="<?php echo date('Y-m-d',strtotime($row['start_date']))?>" class="form-control" placeholder="start_date" required name="start_date">
                                                    </div>
                                                    <div class="form-group">
                                                                <label>deadline</label>
                                                                <input type="date" name="deadline" value="<?php echo date('Y-m-d',strtotime($row['deadline']))?>" class="form-control" placeholder="deadline" required name="deadline">
                                                    </div>
                                                    <div class="form-group">
                                                                <label>status</label>
                                                                <select class="form-control" id="status" name="status" required>
                                                                        <option value="in progress" <?php echo ($row['status']=='in progress')? 'selected' : ''?>>In Progress</option>
                                                                        <option value="on hold"<?php echo ($row['status']=='on hold')? 'selected' : ''?>>On Hold</option>
                                                                </select>
                                                    </div>
                                                    <div class="form-group">
                                                                <button class="btn btn-success" name="submit" type="submit">Save</button>
                                                    </div>
                                            </div>
                                            
                                </div>
                        </div>
                    </form>
                    <?php 
                    return;
                }
            }
            if(isset($_GET['idput'])){  /////////////update project///////////////////
                if(isset($_POST['submit'])){           
                    $project_name = $_POST['project_name'];
                    $start_date = $_POST['start_date'];
                    $deadline = $_POST['deadline'];
                    $status = $_POST['status'];
                    $id = $_GET['idput'];
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
                    require_once ('showresults.php');    
                }
            }
            if(isset($_GET['iddel'])){////////////////delete project///////////////////////
                $id = $_GET['iddel'];
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
                require_once ('showresults.php');
            }            
            if(!isset($_GET['pageNum'])){  /////////show all project pageNum=null//////////////////              
                $star=0;
                $pageSize = 10;                   
                $pageNum =1;
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
                        require_once('addnew.php');
                        exit;
                    }
                    $pageSum = ceil($totalSum/$pageSize);
                    $around = 3;
                    $next = $pageNum + $around;
                    if ($next > $pageSum) {
                            $next = $pageSum;
                    }
                    $pre = $pageNum - $around;
                    if ($pre <= 1) $pre = 1;
                    require_once ('showresults.php');
                    require_once ('details.php');
                    return;
                }    
            }else{//////////////show all project pageNum=$_GET///////////////////////
                $pageNum =1;
                $pageSize = 10;                   
                $pageNum = $_GET['pageNum'];
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
                $res = wp_remote_get("https://erp.cloodo.com/api/v1/project?fields=id%2Cproject_name%2Cproject_summary%2Cnotes%2Cstart_date%2Cdeadline%2Cstatus%2Ccategory%2Cclient%7Bid%2Cname%7D&offset=".$star, $arrs);
                
                if($res['response']['code'] != 200){                       
                    $_SESSION['error'] = 'view project error'; 
                }
                else{
                    $_SESSION['success'] = 'view project';
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
                    require_once ('showresults.php');
                    require_once ('details.php');
                    return;
                }    
            }
        }else{           
            if(isset($_POST['savetoken'])){ ///////token empty show all project when submit ////////////////    
                $token = $_POST['token'];
                $_SESSION['token']= $token;
                $pageSize = 10;
                $pageNum =1;
                $pageNum = $_GET['pageNum'] ?? '1';
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
                    $_SESSION['success'] = 'add token successfuly ! ';
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
                    require_once ('showresults.php');
                    require_once ('details.php');
                    return;
                }    
            }
            require_once ('addtoken.php');
        }    
    }     
} 
add_action('admin_init','headerlocation');