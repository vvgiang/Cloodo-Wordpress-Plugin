<?php 
add_action( 'wp_ajax_ajax_demo','wp_ajax_ajax_demo_func' );
add_action( 'wp_ajax_nopriv_ajax_demo','wp_ajax_ajax_demo_func' );
function wp_ajax_ajax_demo_func(){
    if(!isset($_GET['pageNum'])){  /////////show all lead pageNum=null////////////////// 
        ob_start();          
        $star = 0;
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
                'Authorization'=>'Bearer '.$_SESSION['token'],
                'Content-Type'=>'application/json',
            ],
            'cookie'=>[],
        ];
        // $limit = wp_ajax_ajax_demo_func();
        $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offet='.$star.'&limit='.$pageSize, $arrs);
        if($res['response']['code'] != 200){                   
            $_SESSION['error'] = 'view lead error!';                    
        }    
        else{                    
            $_SESSION['success'] = 'view lead successfuly ';
            $arr = json_decode($res['body'],true); 
            $totalSum = $arr['meta']['paging']['total'];
            if($totalSum == '0'){
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/add-lead.php'));
                return;
            }
            $pageSum = ceil($totalSum/$pageSize);
            $ofsetPageMax = ($pageSum-1) * $pageSize;
            $resPageMax = wp_remote_get("https://erp.cloodo.com/api/v1/lead?offset=".$ofsetPageMax.'&limit='.$pageSize, $arrs);
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
        $result = ob_get_clean(); //cho hết bộ nhớ đệm vào biến $result
        wp_send_json_success($res); // trả về giá trị dạng json
        die();//bắt buộc phải có khi kết thúc
    }else{//////////////show all lead pageNum=$_GET///////////////////////
        ob_start();
        $pageSize = (isset($_POST['value'])? sanitize_text_field($_POST['value']) : 10);                      
        $pageNum = isset($_GET['pageNum'])? sanitize_text_field($_GET['pageNum']) : 1;
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
        $res = wp_remote_get('https://erp.cloodo.com/api/v1/lead/?fields=id,company_name,client_name,value,next_follow_up,client_email,client{id,name}&offet='.$star.'&limit='.$pageSize, $arrs);
        if($res['response']['code'] != 200){                       
            $_SESSION['error'] = 'view lead error';
        }
        else{
            $_SESSION['success'] = 'view lead successfuly ';
            $arr = json_decode($res['body'],true);
            $totalSum = $arr['meta']['paging']['total'];
            if($totalSum == '0'){
                require_once(str_replace('\\','/', plugin_dir_path( __FILE__ ).'call-api-lead/add-lead.php'));
                return;
            }
            $pageSum = ceil($totalSum/$pageSize);
            $ofsetPageMax = ($pageSum-1) * $pageSize;
            $resPageMax = wp_remote_get("https://erp.cloodo.com/api/v1/lead?offset=".$ofsetPageMax.'&limit='.$pageSize, $arrs);
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
        $result = ob_get_clean(); //cho hết bộ nhớ đệm vào biến $result
        wp_send_json_success($res); // trả về giá trị dạng json
        die();//bắt buộc phải có khi kết thúc
    }  
}