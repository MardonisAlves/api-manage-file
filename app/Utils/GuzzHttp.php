<?php
namespace App\Utils;

use App\Helpers\Header;
use GuzzleHttp\Client;

class GuzzHttp
{

    public static function ClientHttp()
    {
        try {
            $urlEndpoint = $_ENV['URL_ENDPOINT'];
            $privateBase64 = $_ENV['PRIVATE_KEY'];
            $publicBase64 = $_ENV['PUBLIC_KEY'];
            $encode64 = base64_encode($privateBase64 . ':' . $publicBase64);

            ;
            $client = new Client([
                'base_uri' => $urlEndpoint,
                'verify' => false,
                'headers' => [
                    'Authorization' => 'Basic ' . $encode64,
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
            ]);
            return $client;
        } catch (\Throwable $th) {
            return Header::validateRequest((int) 500, $th->getMessage());
        }
    }
}