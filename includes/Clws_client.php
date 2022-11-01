<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
} 
class Clws_client extends Clws_API {
    public function clws_access_clients() {
        if ( class_exists( 'WooCommerce' ) ) {
            $this-> clws_client_sync();
        }
        Clws_resource::view('clients.php');
    }
    public function clws_client_sync() {
        $res = Clws_client::call_api_get(CLWS_API_GET_CLIENT_URL);
        if (is_wp_error($res)) {
            $_SESSION['error'] = $res->get_error_message();
        } elseif ($res['response']['code'] != 200) {                   
            $_SESSION['error'] = 'Client sync error!';                    
        } else {
            $arr = Clws_client::swap_json($res['body']);
            $totalSum = $arr['meta']['paging']['total'];
            $res_all = Clws_client::call_api_get(CLWS_API_GET_ALL_CLIENT_URL.$totalSum);
            $all_data = Clws_client::swap_json($res_all['body']);
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
                    $data = [
                        'name' => sanitize_text_field($data['billing']['first_name'].' '.$data['billing']['last_name']),
                        'email' => sanitize_email($data['billing']['email']),
                        'password' => sanitize_text_field($randPass),
                        'mobile' => sanitize_text_field($data['billing']['phone']),
                        'client_detail' => [
                            'company_name'=> sanitize_text_field($data['billing']['company']),
                            'address'=> sanitize_text_field($data['billing']['address_1']),
                            'city'=> sanitize_text_field($data['billing']['city']),
                            'postal_code'=> sanitize_text_field($data['billing']['postcode']),
                            'shipping_address'=> sanitize_text_field($data['billing']['address_2']),
                        ] 
                    ];
                    Clws_client::call_api_post(CLWS_API_POST_CLIENT_URL,$data);
                }
            }
        }
    } 
}