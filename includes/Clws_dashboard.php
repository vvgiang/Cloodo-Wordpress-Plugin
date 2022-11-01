<?php 
    if ( !function_exists( 'add_action' ) ) {
        echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
        exit;
    }
class Clws_dashboard extends Clws_API {
    public function clws_access_dashboard() {
        if (!empty(get_option('cloodo_token'))) {
            new Clws_postMesage;
        } elseif (isset($_POST['Register_quickly'])) {
            $this->Register();
        }
        Clws_resource::view('show-session.php');
        Clws_resource::view('dashboard.php');
    }
    public function Register() {
        $randpw = substr(md5(rand(0, 99999)), 0, 6);
        $data = [
        'company_name' => Clws_add_menu::$company_name ,
        'email' => Clws_add_menu::$email_adm ,
        'website' => Clws_add_menu::$name_site ,
        'password' =>  $randpw ,
        'password_confirmation' =>  $randpw 
        ];
        $res = Clws_dashboard::call_api_post(CLWS_API_CREATE_URL,$data);
        if (is_wp_error($res)) {
            $_SESSION['error'] =  $res->get_error_message();
        } elseif ($res['response']['code'] != 200) {                   
            $_SESSION['error'] = 'create error !';                    
        } else {
            $result = self::swap_json($res['body']);
            if(isset($result['status']) == 'success') {
                $data = [
                    'email' => Clws_add_menu::$email_adm,
                    'password' => $randpw
                ];
                $resultLogin = Clws_dashboard::call_api_post(CLWS_API_LOGIN_URL,$data);
                if (is_wp_error($resultLogin)) {
                    $_SESSION['error'] =  $resultLogin->get_error_message();
                } elseif ($resultLogin['response']['code'] != 200) {                   
                    $_SESSION['error'] = 'login error !';                    
                } else {
                    $result = self::swap_json($resultLogin['body']);
                    $id_token = $result['data']['token'];
                    update_option('cloodo_token', $id_token);
                    $dataoption[] = [
                        'token'=> $id_token,
                        'email'=> Clws_add_menu::$email_adm
                    ];
                    $dataoption = maybe_serialize($dataoption);
                    update_option('clodo_user', $dataoption);
                    new Clws_postMesage();
                }
            } else {
                $_SESSION['error'] = 'The Accounts already exists or has not activated email, please try again !';
            } 
        }
    }
}
