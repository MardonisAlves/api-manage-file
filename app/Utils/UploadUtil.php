<?php
namespace App\Utils;
use App\Helpers\Header;
use Exception;
;



class UploadUtil
{

    public static function sendFile($namefile)
    {
        try {
           $client= GuzzHttp::ClientHttp();
            $filePath =  './uploads/'.$namefile;
            $base64Image = base64_encode(file_get_contents($filePath));
            if (file_exists($filePath)) {
               $response = $client->request('POST', 'files/upload/', [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $base64Image,
                        'headers'  => ['Content-Type' => 'application/json'],
                       
                    ],
                    [
                        'name'     => 'fileName',
                        'contents' => $namefile,
                    ],
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents());
            unlink($filePath);
            return Header::validateRequest($statusCode, $body);
            } else {
                return Header::validateRequest((int) 204, 'arquivo não encontrado');
            }
        } catch (Exception $th) {
            return Header::validateRequest((int) 500, 'Erro durante o upload: ' . $th->getMessage());
        }
    }

}