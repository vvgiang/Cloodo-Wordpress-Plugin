<?php
session_start();
/**
 * Plugin Name:       call api wordpress
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       demo CRUD call api test
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
add_action( 'admin_menu', 'wporg_options_page' );
function wporg_options_page() {
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        'wporg',
        'wporg_options_page_html',
        plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
        20
    );
}
function wporg_options_page_html() {
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wporg' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
    <?php
}
add_action( 'admin_menu', 'wporg_options_page1' );
function wporg_options_page1() {
    add_menu_page(
        'WPOrg',
        'WPOrg Options',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/view.php',
        null,
        plugin_dir_url(__FILE__) . 'images/icon_wporg.png',
        20
    );
}
//////////////////////////////////////menu/////////////////////////
function add_submenu_options()
{
    add_submenu_page(
            'themes.php', // Menu cha
            'hoanle 123', // Tiêu đề của menu
            'Login get API', // Tên của menu
            'manage_options',// Vùng truy cập, giá trị này có ý nghĩa chỉ có supper admin và admin đc dùng
            'theme-options', // Slug của menu
            'access_menu_options' // Hàm callback hiển thị nội dung của menu
    );
}
add_action('admin_menu', 'add_submenu_options');
//click menu function runing
function access_menu_options(){

    if(isset($_POST['save'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        if($email && $password != '')
        {
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
        if($res['response']['code'] != 200)
        {
           $_SESSION['error'] = 'sai tai khoan hoac mat khau';
         
        }
        else
        {
           $res = json_decode($res['body'],true);
            $id_token = $res['data']['token'];
             $_SESSION['success'] = 'Get token ';
            //  print_r($id_token);
            //  var_dump($_SESSION);
        }       
        }        
    }
    require_once ('theme.php');
}
///////////////////////////////////////////////////////////////////////////////////////////////////

function add_submenu_options2()
{
    add_submenu_page(
            'themes.php', // Menu cha
            'hoanle 4', // Tiêu đề của menu
            'CRUD project', // Tên của menu
            'manage_options',// Vùng truy cập, giá trị này có ý nghĩa chỉ có supper admin và admin đc dùng
            'theme-options1', // Slug của menu
            'access_getAll' // Hàm callback hiển thị nội dung của menu
    );
}
// unset($_SESSION['token']);
add_action('admin_menu', 'add_submenu_options2');
function headerlocation(){
    function access_getAll(){ 
    require_once ('showresults.php');
    if(isset( $_SESSION['token']))//////////////////////////////////
    {   $pageSize = 10;   
            // add them project 
        if(isset($_GET['view']) && $_GET['view']=='post')
        {
            require_once ('addnew.php');
            return;
        }
        if(isset($_GET['idadd'])){/////////////////////////////////////
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
                        // 'Content-Type'=>'application/json',
                    ],
                    'cookie'=>[],
                ];
                $res = wp_remote_request('https://erp.cloodo.com/api/v1/project', $arrs);
                if($res['response']['code'] != 200)
                {
                    $_SESSION['error'] = 'add project error';  
                }
                else
                {
                    $_SESSION['success'] = 'add project ';
                    $arr = json_decode($res['body'],true);
                    $row =$arr['data'];
                }
                }
        }
            // lay ra thong tin 1 project
            // if(isset($_GET['view']) && $_GET['view']=='edit')
            // {
            //     require_once ('edit.php');
            //     // return;
            // }
            if(isset($_GET['id']))
            {
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
                if($res['response']['code'] != 200)
                    {
                       $_SESSION['error'] = ' Get project error!';
                     
                    }
               else
                    {
                        $_SESSION['success'] = 'Get project ';
                        $arr = json_decode($res['body'],true);
                        $row =$arr['data'];
                        require_once ('edit.php');
                        return;
                    }
            }
            //show all project
            if(!isset($_GET['pageNum']))
            {
            $star=0;
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
            
            if($res['response']['code'] != 200)
                {
                   $_SESSION['error'] = 'view project error!';
                 
                }
           else
                {
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
                    require_once ('details.php');
                    return;
                }
            }else{
                $pageNum =1;
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
                
                if($res['response']['code'] != 200)
                    {
                       $_SESSION['error'] = 'view project error';
                     
                    }
               else
                    {
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
                        require_once ('details.php');
                        return;
                    }
            }
    }
        else
            {
                //show all project when not submit
                if(isset($_POST['savetoken']))
                    {   
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
                        if($res['response']['code'] != 200)
                            {
                               $_SESSION['error'] = 'add token';
                             
                            }
                       else
                            {
                                $_SESSION['success'] = 'add token ';
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
                                require_once ('details.php');
                                return;
                            }
                    }
            }
       
        require_once ('addtoken.php');
    }
    if(isset($_GET['idput']))
    {
        if(isset($_POST['submit']))
        {
            $project_name = $_POST['project_name'];
            $start_date = $_POST['start_date'];
            $deadline = $_POST['deadline'];
            $status = $_POST['status'];
        
        $id = $_GET['idput'];
        $arrs =[
            'method'=> 'PUT',
            'body'=>[
                'project_name'=> $project_name,
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
                // 'Content-Type'=>'application/json',
            ],
            'cookie'=>[],
        ];
        $res = wp_remote_request('https://erp.cloodo.com/api/v1/project/'.$id, $arrs);
        if($res['response']['code'] != 200)
            {
               $_SESSION['error'] = 'update! ';
             
            }
       else
            {
                $_SESSION['success'] = 'update! ';
            }
        }
    }
    if(isset($_GET['iddel']))
    {
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
        if($res['response']['code'] != 200)
        {
          $_SESSION['error'] ='delete';
        }else{
          $_SESSION['success'] ='delete';
        }
    }
      
 
}
add_action('admin_init','headerlocation');
function demo1()
{
    $url= get_site_url();   
    $newurl = (explode("/",trim($url,"/")))[2] ;
    echo '<iframe src="https://cloodo.com/trustscore/' . $newurl . '"'.'frameborder="0" width="auto" height="300px" scrolling="no" />';

}
add_action( 'wp_footer', 'demo1' );






function register_mysettings() {
        register_setting( 'mfpd-settings-group', 'mfpd_option_name' );
}
function mfpd_create_menu() {
        add_menu_page('My First Plugin Settings', 'MFPD Settings', 'administrator', __FILE__, 'mfpd_settings_page',plugins_url('/images/icon.png', __FILE__), 1);
        add_action( 'admin_init', 'register_mysettings' );
}
add_action('admin_menu', 'mfpd_create_menu'); 


function mfpd_settings_page() {
?>
<div class="wrap">
<h2>Tạo trang cài đặt cho plugin</h2>
<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>
<form method="post" action="options.php">
    <?php settings_fields( 'mfpd-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Tùy chọn cài đặt</th>
        <td><input type="text" name="mfpd_option_name" value="<?php echo get_option('mfpd_option_name'); ?>" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php } ?>
