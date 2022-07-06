<?php
namespace Nwidart\Modules\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

trait GamotaHelperTrait
{
    private $client;
    private $nap_url = 'https://nap.gamota.com';
    private $nap_dev_url = 'https://nap.dev.gamota.com';
    private $nap_get_list_game_secret_key;
    private $nap_secret_key;
    private $nap_get_role_secret_key;
    private $pay_auth_secret_key;
    private $game_api_key;

    public function __construct()
    {
        $this->client = new Client();
        $this->nap_get_list_game_secret_key = env('PURCHASE_LIST_GAME_SECRET_KEY');
        $this->nap_secret_key = env('PURCHASE_SECRET_KEY');
        $this->nap_get_role_secret_key = env('PURCHASE_GET_ROLE_SECRET_KEY');
        $this->pay_auth_secret_key = env('PAY_AUTH_SECRET_KEY');
        $this->game_api_key = env('GAME_API_KEY');
    }

    public static function send_tele($title, $message)
    {
        $apiToken = env('TELEGRAM_API_KEY');
        $data = [
            'chat_id' => '@gameblogcronnotification',
            'text' => $title . '\n' . $message,
        ];

        $full_url = "https://api.telegram.org/bot$apiToken/sendMessage";

        $response = self::$client->request('GET', $full_url . http_build_query($data));
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $result = json_decode($body, true);

            if (isset($result['error']) && $result['error'] == 0) {
                return true;
            }
        }

        return false;
    }

    // public function get_list_game($dev = false)
    // {
    //     if ($dev) {
    //         $nap_url = $this->nap_dev_url;
    //     } else {
    //         $nap_url = $this->nap_url;
    //     }
    //     $url = $nap_url . "/api/get-list-games";

    //     $time = time();
    //     $params = array(
    //         'time' => $time,
    //         'sign' => md5($time),
    //     );

    //     $data = array();
    //     $str_token = serialize($params);
    //     $token = $this->_AES_256_CBC_Encrypt($str_token, $this->nap_get_list_game_secret_key);

    //     $full_url = $url . '?token=' . $token;

    //     if ($dev) {
    //         $data_header = array(
    //             'username' => 'otoc',
    //             'password' => 'lttt',
    //         );

    //         $data_auth = 'otoc:lttt';

    //         $curl_result = Curl_Helper::send_curl($full_url, $data, Curl_Helper::METHOD_GET, $data_header, $data_auth);
    //     } else {
    //         $curl_result = Curl_Helper::send_curl($full_url, $data, Curl_Helper::METHOD_GET);
    //     }

    //     if ($curl_result['http_code'] == 200) {
    //         $result = json_decode($curl_result['body'], true);
    //         if (isset($result['errorCode']) && $result['errorCode'] == 0) {
    //             return $result['data'];
    //         } else {
    //             return null;
    //         }

    //     } else {
    //         return null;
    //     }
    // }

    /* get all server by game of user */
    /**
     * @param int $game_id
     **/
    public function get_list_server_by_game()
    {
        if (env('APP_ENV') == 'production') {
            $nap_url = $this->nap_url;
        } else {
            $nap_url = $this->nap_dev_url;
        }
        $url = $nap_url . "/api/get-list-server";

        $params = array(
            'api_key' => trim($this->game_api_key),
        );

        $data = [];
        $str_token = serialize($params);
        $token = $this->_AES_256_CBC_Encrypt($str_token, $this->nap_secret_key);

        $full_url = $url . '?token=' . $token;

        $response = $this->client->request('GET', $full_url);
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $result = json_decode($body, true);

            if (isset($result['errorCode']) && $result['errorCode'] == 0) {
                $data_server = $result['data'];
                $list_server = array();

                if (count($data_server) > 0) {
                    foreach ($data_server as $server_group) {
                        $list_server = $list_server + $server_group['list'];
                    }
                }

                return $list_server;
            }
        }

        return [];
    }

    /* get character info by server
     *
     * @param (int) game_id
     * @param server_id
     */
    public function api_get_all_character_by_server($server_id = '', $user_id = '')
    {
        if (env('APP_ENV') == 'production') {
            $nap_url = $this->nap_url;
        } else {
            $nap_url = $this->nap_dev_url;
        }
        $url = $nap_url . "/api/get-list-roles";

        if ($this->game_api_key == '' || $server_id == '' || $user_id == '') {
            return null;
        }

        $params = array(
            'api_key' => trim($this->game_api_key),
            'server_id' => trim($server_id),
            'appota_user_id' => trim($user_id),
        );

        $str_token = serialize($params);
        $token = $this->_AES_256_CBC_Encrypt($str_token, $this->nap_get_role_secret_key);
        $full_url = $url . '?token=' . $token;

        if (env('APP_ENV') != 'production') {
            $data_header = array(
                'username' => 'otoc',
                'password' => 'lttt',
            );
            $response = $this->client->request('GET', $full_url, [
                'auth' => [$data_header['username'], $data_header['password']],
            ]);
        } else {
            $response = $this->client->request('GET', $full_url);
        }

        if ($response->getStatusCode() == 200) {
            $body = $response->getBody()->getContents();

            $result = json_decode($body, true);
            if (isset($result['errorCode']) && $result['errorCode'] == 0) {
                $list_roles = $result['data'];

                return $list_roles;
            } else {
                Log::debug(json_encode($result));
            }
        }

        return [];
    }

    // public function get_user_info($username = '')
    // {
    //     $url = 'https://api.appota.com/gameaccount/getUserInfoByUsername?api_key=K-A189391-U00000-IAEYUJ-EB527995DBD7EAA2';

    //     if ($username == '') {
    //         return null;
    //     }

    //     $params = array(
    //         'username' => (string) $username,
    //     );

    //     $rs = Curl_Helper::send_curl($url, $params, Curl_Helper::METHOD_POST);

    //     $result = json_decode($rs['body'], true);

    //     if ($result['error_code'] == 0) {
    //         return $result['data']['current_point'];
    //     } else {
    //         return 0;
    //     }
    // }

    // public function get_user_info_by_access_token($access_token)
    // {
    //     $url = 'https://gamota.com/api/login/appota_access_token';
    //     $data['appota_token'] = $access_token;
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     # TODO: add header options

    //     $res = curl_exec($ch);

    //     $info = curl_getinfo($ch);
    //     curl_close($ch);
    //     if (!$info['http_code']) {
    //         error_log('failed to connect to Gamota server');
    //         return false;
    //     }
    //     $json = json_decode($res, true);

    //     if ($json['error_code'] != 0) {
    //         return 0;
    //     }

    //     return $json;
    // }

    // public function get_total_amount($user_id = '', $start_time = '', $end_time = '')
    // {
    //     $url = 'https://olap.gamota.com/v1/payment/user/list-info';

    //     if ($user_id == '') {
    //         return null;
    //     }

    //     $params = array(
    //         'user_ids' => $user_id,
    //         'api_key' => 'shop-G7efj5euVMHfC0K',
    //     );

    //     if ($start_time != '') {
    //         $params['start_time'] = strtotime($start_time);
    //     }

    //     if ($end_time != '') {
    //         $params['end_time'] = strtotime($end_time);
    //     }
    //     ksort($params);
    //     $signature = sha1(implode('|', $params) . '|ceFqqTzJozC4ZcmQnPNCYPP82');
    //     if ($signature == '') {
    //         return null;
    //     }

    //     $params['signature'] = $signature;

    //     $result = Curl_Helper::send_curl($url, $params, Curl_Helper::METHOD_POST);

    //     if ($result['http_code'] == 200) {
    //         $result = json_decode($result['body'], true);

    //         if ($result['errorCode'] == 0 && isset($result['data'][0]['user_id']) && $result['data'][0]['user_id'] == $user_id) {
    //             return $result['data'][0]['amount'];
    //         }

    //     }

    //     return 0;
    // }

    // public function get_role_time($role_id = '')
    // {
    //     $url = 'https://olap.gamota.com/v1/lookup/user/info';

    //     if ($role_id == '') {
    //         return null;
    //     }

    //     $params = array(
    //         'role_id' => $role_id,
    //         'product_id' => '180419',
    //         'api_key' => 'shop-G7efj5euVMHfC0K',
    //     );

    //     ksort($params);
    //     $signature = sha1(implode('|', $params) . '|ceFqqTzJozC4ZcmQnPNCYPP82');
    //     if ($signature == '') {
    //         return null;
    //     }

    //     $params['signature'] = $signature;

    //     $result = Curl_Helper::send_curl($url, $params, Curl_Helper::METHOD_GET);

    //     if ($result['http_code'] == 200) {
    //         $result = json_decode($result['body'], true);

    //         if ($result['errorCode'] == 0) {
    //             $min = $result['data'][0]['time'];
    //             for ($i = 1; $i < count($result['data']); $i++) {
    //                 if ($result['data'][$i]['time'] < $min) {
    //                     $min = $result['data'][$i]['time'];
    //                 }

    //             }
    //             return $min;
    //         }
    //     }
    // }

    // public function get_total_amount_by_game($user_id, $options = [])
    // {
    //     $url = 'https://olap.gamota.com/v1/payment/user/charge-info';
    //     if (!$user_id) {
    //         return 0;
    //     }

    //     $params = array(
    //         'user_id' => $user_id,
    //         'api_key' => 'shop-G7efj5euVMHfC0K',
    //         'product_id' => 'GMA0072',
    //     );

    //     if (isset($options['start_time'])) {
    //         $params['start_time'] = strtotime($options['start_time']);
    //     }

    //     if (isset($options['end_time'])) {
    //         $params['end_time'] = strtotime($options['end_time']);
    //     }

    //     ksort($params);
    //     $signature = sha1(implode('|', $params) . '|ceFqqTzJozC4ZcmQnPNCYPP82');
    //     if ($signature == '') {
    //         return null;
    //     }

    //     $params['signature'] = $signature;
    //     $result = Curl_Helper::send_curl($url, $params, 'get');

    //     if ($result['http_code'] == 200) {
    //         $result = json_decode($result['body'], true);

    //         if ($result['errorCode'] == 0 && isset($result['data']['total_amount'])) {
    //             return $result['data']['total_amount'];
    //         }

    //     }

    //     return 0;
    // }

    // public function get_discount_amount_by_game($user_id, $options = [])
    // {
    //     $url = 'https://olap.gamota.com/v1/lookup/transaction/list';
    //     if (!$user_id) {
    //         return 0;
    //     }

    //     $params = array(
    //         'api_key' => 'shop-G7efj5euVMHfC0K',
    //         'product_id' => 'GMA0072',
    //         'fields' => 'package_id,amount_local',
    //         'filters' => json_encode(['user_id' => [(int) $user_id]]),
    //         'limit' => isset($options['limit']) ? (int) $options['limit'] : 100000,
    //         'offset' => isset($options['offset']) ? (int) $options['offset'] : 0,
    //         'start_time' => isset($options['start_time']) ? strtotime($options['start_time']) : strtotime('2017/01/01 00:00:00'),
    //         'end_time' => isset($options['end_time']) ? strtotime($options['end_time']) : time(),
    //     );

    //     ksort($params);
    //     $signature = sha1(implode('|', $params) . '|ceFqqTzJozC4ZcmQnPNCYPP82');
    //     if ($signature == '') {
    //         return null;
    //     }

    //     $params['signature'] = $signature;

    //     $result = Curl_Helper::send_curl($url, $params, 'get');
    //     $total_amount = 0;

    //     if ($result['http_code'] == 200) {
    //         $result = json_decode($result['body'], true);
    //         if ($result['errorCode'] == 0 && !empty($result['data']['items'])) {
    //             $discount_packages = $this->CI->config->item('discount_packages');
    //             foreach ($result['data']['items'] as $trans) {
    //                 $total_amount += array_key_exists($trans['package_id'], $discount_packages) ? $discount_packages[$trans['package_id']] : $trans['amount_local'];
    //             }
    //         }
    //     }

    //     return $total_amount;
    // }

    // public function send_gift($server_id = '', $role_id = '', $package_id = '')
    // {
    //     $url = 'https://apisdk.gamota.com/gamota/games/trutien/giftcode';
    //     $secret_key = '9uxL7zJXEWKdW3DM1uZKsmBQwsHVCXzn';

    //     $params = [
    //         'package_id' => $package_id,
    //         'role_id' => $role_id,
    //         'server_id' => $server_id,
    //     ];

    //     $params['hash'] = md5(implode('|', $params) . "|" . $secret_key);
    //     $params['api_key'] = 'A180419-KRZ2QY-3FF02515D1088333';

    //     $result = Curl_Helper::send_curl($url, $params, 'get');
    //     return $result;
    // }

    private function _AES_256_CBC_Encrypt($data, $privateKey)
    {
        if (!is_string($data)) {
            throw new \Exception("[AES_Encrypt] data input must be a tring!");
        }
        if (!function_exists('openssl_encrypt')) {
            throw new \Exception("Function openssl_encrypt could not be found!");
        }
        $iv = substr(bin2hex(random_bytes(32)), 0, 16);
        $aes_code = openssl_encrypt($data, 'AES-256-CBC', $privateKey, 0, $iv);
        return base64_encode($iv . $aes_code);
    }
}
