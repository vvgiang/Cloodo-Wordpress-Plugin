<?php 
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
class Clws_product extends Clws_API {
    public function clws_access_products() {
        if ( class_exists( 'WooCommerce' ) ) {
            $this-> clws_product_sync();
        }
        Clws_resource::view('products.php');
    }
    public function clws_product_sync() {
        $res = Clws_client::call_api_get(CLWS_API_GET_PRODUCT_URL);
        if (is_wp_error($res)) {
            $_SESSION['error'] = $res->get_error_message();
        } elseif ($res['response']['code'] != 200) {                   
            $_SESSION['error'] = 'Client sync error!';                    
        } else {
            $arr = Clws_client::swap_json($res['body']);
            $totalSum = $arr['meta']['paging']['total'];
            $res_all = Clws_client::call_api_get(CLWS_API_GET_ALL_PRODUCT_URL.$totalSum);
            $all_data = Clws_client::swap_json($res_all['body']);
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
                if (!in_array($data['id'], $customArr)) {
                    echo 'dang ky';
                    $data = [
                        'name' => $data['name'] ,
                        'price' => $data['price'],
                        'hsn_sac_code' => $data['id'],
                        'description' => $data['short_description'],
                    ];
                    Clws_product::call_api_post(CLWS_API_POST_PRODUCT_URL,$data);
                }
            }
        }
    }
}