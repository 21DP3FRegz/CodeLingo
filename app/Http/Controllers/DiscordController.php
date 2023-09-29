<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use \GuzzleHttp;

class DiscordController extends Controller
{
    protected $tokenURL = "https://discord.com/api/oauth2/token";
    protected $apiURLBase = "https://discord.com/api/users/@me";
    protected $tokenData = [
        "client_id" => NULL,
        "client_secret" => NULL,
        "grant_type" => "authorization_code",
        "code" => NULL,
        "redirect_uri" => NULL,
        "scope" => "identifiy&guilds"
    ];

    public function login()
    {
        $discord_url = env('DISCORD_URL');
        return redirect($discord_url);
    }

    public function processOauth()
    {
        abort_unless(isset($_GET['code']), 400, "No discord authorization code");

        $this->tokenData["client_id"] = env("DISCORD_CLIENT_ID");
        $this->tokenData["client_secret"] = env("DISCORD_CLIENT_SECRET");
        $this->tokenData["code"] = $_GET['code'];
        $this->tokenData["redirect_uri"] = env("DISCORD_REDIRECT_URI");

        $client = new GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,)));

        try {
            $accessTokenData = $client->post($this->tokenURL, ["form_params" => $this->tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $error) {
            abort(400, "Bad request");
        };

        $authToken = $accessTokenData->access_token;
        $header = array("Authorization: Bearer $authToken", "Content-Type: application/x-www-form-urlencoded");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $this->apiURLBase);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $userData = curl_exec($ch);

        $userData = json_decode($userData, true);

        $this->addUserToGuild($userData['id'], $authToken, env('DISCORD_GUILD_ID'));

        return $userData;
    }

    public function addUserToGuild($discord_ID, $token, $guild_ID)
    {
        $payload = [
            'access_token' => $token,
        ];

        $discord_api_url = 'https://discordapp.com/api/guilds/' . $guild_ID . '/members/' . $discord_ID;

        $bot_token = env('DISCORD_BOT_ID');
        $header = array("Authorization: Bot $bot_token", "Content-Type: application/json");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $discord_api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);

        if (!$result) {
            abort(400, "Bad request");
        }
    }
}
