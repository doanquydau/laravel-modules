<?php
namespace Nwidart\Modules\Traits;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

trait GamotaLoginHelperTrait
{
    protected $api_key;
    protected $client_login;
    protected $message_login;

    public function login(Request $request)
    {
        $this->client_login = new Client();
        $this->api_key = env('APPOTA_API_KEY');

        if ($request->has('username') && $request->has('password')) {
            $username = $request->get('username');
            $password = $request->get('password');

            $login_result = $this->login_appota($username, $password);
        } elseif ($request->has('google_token') && !empty($request->get('google_token'))) {
            $google_token = $request->get('google_token');
            $login_result = $this->login_appota_with_provider($google_token, 'google');
        } elseif ($request->has('facebook_token') && !empty($request->get('facebook_token'))) {
            $facebook_token = $request->get('facebook_token');
            $login_result = $this->login_appota_with_provider($facebook_token, 'facebook');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Bạn phải nhập đầy đủ tên đăng nhập và mật khẩu',
            ]);
        }

        $login_result = json_decode($login_result, true);
        if ($login_result['error_code'] != 0) {

            if ($login_result['error_code'] == 54) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email, tên đăng nhập hoặc mật khẩu không đúng!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Đăng nhập thất bại. Vui lòng thử lại',
            ]);
        }

        $user_data = array(
            'appota_userid' => !empty($login_result['data']['user_id']) ? $login_result['data']['user_id'] : $login_result['user_id'],
            'appota_username' => !empty($login_result['data']['username']) ? $login_result['data']['username'] : $login_result['username'],
        );

        $user = User::where('appota_userid', $user_data['appota_userid'])->first();

        if (empty($user)) {
            User::create($user_data);
        }

        $tokenResult = $user->createToken(env('APP_KEY'));
        $data_response = array(
            "appota_userid" => $user->appota_userid,
            "appota_username" => $user->appota_username,
            'token' => $tokenResult->accessToken,
            'expired' => Carbon::parse(
                $tokenResult->token->expires_at
            )->timestamp,
        );

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $data_response,
        ]);
    }

    public function get_user_info_by_access_token($accessToken)
    {
        $api_url = "https://api.appota.com/game/get_user_info?access_token=$accessToken";

        $response = $this->client_login->request('GET', $api_url);
        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $result = json_decode($body, true);

            if (isset($result['errorCode']) && $result['errorCode'] == 0) {
                return $result['data'];
            }
        }
        return false;
    }

    private function login_appota($username, $password)
    {
        $client_id = request()->ip();
        if (!in_array($client_id, ['127.0.0.1', '210.211.100.181', '118.70.28.215', '118.70.28.200', '113.190.242.72', '123.25.30.71', '115.78.95.5', '172.23.0.1'])) {
            Log::debug('IP address is not allowed: ' . $client_id);
            return false;
        }
        $api_url = "https://api.gamota.com/game/login?access_token=" . $this->api_key . "&lang=vi";

        $params = [
            'username' => $username,
            'password' => $password,
            'device_id' => md5(rand() . time()),
        ];

        $response = $this->client_login->request('POST', $api_url, [
            'form_params' => $params,
        ]);
        return $response->getBody();
    }

    private function login_appota_with_provider($accessToken, $provider = 'google')
    {
        switch ($provider) {
            case 'google':
                $api_url = "https://api.gamota.com/game/login_google?access_token=" . $this->api_key . "&lang=vi";
                $params = [
                    'google_access_token' => $accessToken,
                ];
                break;
            case 'facebook':
                $api_url = "https://api.gamota.com/game/login_facebook?access_token=" . $this->api_key . "&lang=vi";
                $params = [
                    'facebook_access_token' => $accessToken,
                ];
                break;
            default:
                return false;
                break;
        }

        $response = $this->client_login->request('POST', $api_url, [
            'form_params' => $params,
        ]);
        return $response->getBody();
    }
}
