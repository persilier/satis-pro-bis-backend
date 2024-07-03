<?php


namespace Satis2020\ServicePackage;


use GuzzleHttp\Client;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Httpful\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MessageApiMethod
{
    /**
     * oceanicsms.com Message Api
     *
     * @param $user
     * @param $password
     * @param $from
     * @param $to
     * @param $text
     * @param $api
     * @return mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    static public function toOceanicsms($user, $password, $from, $to, $text, $api)
    {
        $response = Http::asForm()->post('http://oceanicsms.com/api/http/sendmsg.php', [
            'user' => $user,
            'password' => $password,
            'from' => $from,
            'to' => $to,
            'text' => $text,
            'api' => $api
        ])->body();


        return is_string($response) && str_contains(strtolower($response), "id:");
    }

    /***
     * LONDO SMS API
     *
     * @param $username
     * @param $password
     * @param $client
     * @param $app
     * @param $id
     * @param $priority
     * @param $to
     * @param $text
     * @return array|mixed
     */
    static public function londoSMSApi($username, $password, $client, $app, $id, $priority, $to, $text)
    {
        $headers = [
            "Authorization" => "Basic " . base64_encode("$username:$password")
        ];
        $data = [
            '_id' => $id,
            'priority' => $priority,
            'telephone' => $to,
            'message' => $text,
            'source' => [
                'client' => $client,
                'app' => $app
            ]
        ];


        $request = Http::withHeaders($headers);

        $proxyConfigs = Config::get('proxy');

        if ($proxyConfigs['http'] || $proxyConfigs['https']) {
            $request = $request->withOptions([
                'proxy' => $proxyConfigs
            ]);
        }

        $response = $request->post("https://gateway.londo-tech.com/api/v1/send/sms", $data);

        Log::debug('londoSMSApiResponse', [
            'messageSent' => ($response->successful() && optional($response->json())['message'] == "message sent successfully.") ? 'yes' : 'no',
            'responseJson' => $response->json()
        ]);

        return $response->successful() && optional($response->json())['message'] == "message sent successfully.";
    }

    static function orangeSMSApi($login, $api_access_key, $token, $subject, $signature, $to, $text)
    {
        $timestamp = time();

        $msgToEncrypt = $token . $subject . $signature . $to . $text . $timestamp;

        $key = hash_hmac('sha1', $msgToEncrypt, $api_access_key);

        $params = [
            'token' => $token,
            'subject' => $subject,
            'signature' => $signature,
            'recipient' => $to,
            'content' => $text,
            'timestamp' => $timestamp,
            'key' => $key
        ];

        $uri = 'https://api.orangesmspro.sn:8443/api';

        $response = Request::post($uri)
            ->body(http_build_query($params))
            ->authenticateWith($login, $token)
            ->send();

        return $response->body;
    }

    /**
     * SONIBANK SMS Gateway
     *
     * @param $username
     * @param $password
     * @param $to
     * @param $text
     * @return array|mixed
     * @throws \Illuminate\Http\Client\RequestException
     */
    static function sonibankSMSGateway($username, $password, $to, $text)
    {
        return Http::get("http://192.168.1.92:13013/cgi-bin/sendsms?username=$username&password=$password&dr-mask=18&charset=ISO8859-1&coding=2&to=$to&text=$text")
            ->throw()->json();
    }

    static function bicecSMSGateway($to, $text)
    {
        $url = "http://10.100.23.21/bicec/admin/json.php?module=sms&action=send_wallet&phone=$to&body=" . urlencode($text);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        @curl_exec($ch);

        return curl_close($ch);
    }


    static function uimcecSMSGateway($to, $text, $login = "satis", $api_access_key = "38d0cd40ece8eee6fb19aeb8d0f6ea2a", $signature = "UIMCEC", $token = "9e5fd4ba3cb3d254780cd5fc0cd2b830")
    {

        $timestamp = time();
        $subject = "UIMCEC";
        $msgToEncrypt = $token . $subject . $signature . $to . $text . $timestamp;
        $key = hash_hmac('sha1', $msgToEncrypt, $api_access_key);
        $params = array(
            'token' => $token,
            'subject' => $subject,
            'signature' => $signature,
            'recipient' => $to,
            'content' => $text,
            'timestamp' => $timestamp,
            'key' => $key
        );
        $uri = 'https://api.orangesmspro.sn:8443/api';

        $response = Request::post($uri)
            ->body(http_build_query($params))
            ->authenticateWith($login, $token)
            ->send();

        return $response->hasErrors() == false && $response->body != null && Str::contains($response->body, "STATUS_CODE: 200");
    }

    static public function coopecSms($from, $to, $text)
    {
        $data = [
            "from" => $from,
            "to" => $to,
            "text" => $text,
            "reference" => Str::random(8),
            "api_key" => "k_Od28TwMjSQQ-7fiFfW4BVE03PIbrwF_s",
            "api_secret" => "s_hZkQBxGDwY3f89MOlw0CEp4tumR818pP"
        ];

        $response =   Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://extranet.nghcorp.net/api/send-sms', $data)->json();

        return $response["status"] == Response::HTTP_OK;
    }
    static function bisOrangeApiSMS($from, $to, $text, $username, $password)
    {
        $authenticationApi = 'https://41.214.72.34:6060/api/authentification';
        $sendSMSApi = 'https://41.214.72.34:6060/api/sms/om/send';
        $params = array(
            "objet" => $from,
            'telephone' => $to,
            "message" => $text,
        );
        // Basic authentication for SMS sending
        $responseAuthentication = Http::withOptions([
            'debug' => true,
            'verify' => false,
        ])->withHeaders([
            "Authorization" => "Basic " . base64_encode("$username:$password")
        ])->post($authenticationApi);
        if (!$responseAuthentication || ($responseAuthentication && $responseAuthentication['codeRetour'] !== "0")) {
            return false;
        }
        $headers = [
            "Authorization" => "Bearer " . $responseAuthentication['token'],
            "Content-Type" => "application/json",
        ];
        // $response  = Request::post($sendSMSApi)->withoutStrictSSL()->addHeaders($headers)
        // ->body(http_build_query($params))
        // ->send();
        $response = Http::withOptions([
            'debug' => true,
            'verify' => false,
        ])->withHeaders($headers)->post($sendSMSApi, $params);

        return $response['codeRetour'] === "0" &&  $response['messageRetour'] === "SMS ENVOYE"; // {"codeRetour":0,"messageRetour":"SMS ENVOYE"} 
    }
}
