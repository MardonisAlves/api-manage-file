<?php
namespace App\Utils;

use ImageKit\ImageKit;
use App\Helpers\Header;
use Exception;

class UploadUtil
{

    public static function sendFile($namefile)
    {
        try {
            $imageKit = new ImageKit(
                $_ENV['PUBLIC_KEY'],
                $_ENV['PRIVATE_KEY'],
                $_ENV['URL_ENDPOINT']
            );

            $filePath = __DIR__. './../../uploads/'.$namefile;
            $base64 = base64_encode(file_get_contents($filePath));
                        
            $file = $imageKit->upload([
                'file' => $base64,
                'fileName' => $namefile,
                "folder" => "/teste",
                "tags" => ['tag1']
            ]);


        } catch (Exception $th) {
            var_dump($th);  
            return Header::validateRequest((int) 500, 'Erro durante o upload: ' . $th->getMessage());
        }
    }

}