<?php
namespace App\ServicesHttp;
use App\Helpers\Header;
use App\Utils\GuzzHttp;
use App\Model\Uploads;
use App\Model\Pathkit;
use Exception;

class UploadService
{

    public static function sendFile($namefile, $path, $userId)
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
                    [
                        'name'     => 'folder',
                        'contents' => $path,
                    ],
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents());
            unlink($filePath);
            $upload = new Uploads;
            $upload->user_id = $userId;
            $upload->url = $body->url;
            $upload->path = $body->filePath;
            $upload->file_name = $body->name;
            if(isset($body->thumbnailUrl)) {
                $upload->thumbnailUrl = $body->thumbnailUrl;
            }else{
                $upload->thumbnailUrl =  '';
            }
            $upload->fileId =  $body->fileId;
            $upload->save();
           return Header::validateRequest($statusCode, $body);
           
            } else {
                return Header::validateRequest((int) 204, 'arquivo não encontrado');
            }
        } catch (Exception $th) {
            return Header::validateRequest((int) 500, 'Erro durante o upload: ' . $th->getMessage());
        }
    }

    public static function deleteFile($fileId){
        try {
            $client = GuzzHttp::ClientHttp();
            $client->request('DELETE', "files/{$fileId}");
            return Header::validateRequest((int) 200, 'File deletado com sucesso');
        } catch (\Throwable $th) {
            return Header::validateRequest((int) 500,  $th->getMessage());
        }
    }

    public static function listFileUpload(){
        try {
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('GET', 'files');
            $body = json_decode($response->getBody()->getContents());
            $statusCode = $response->getStatusCode();

            return Header::validateRequest($statusCode, $body);
        } catch (Exception $e) {
            return Header::validateRequest((int) 500,  $e->getMessage());
        }
    }

    public static function deleteFileUpload($nameFolder){
        try {
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('POST','folder',['folderName'=> $nameFolder]);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents());
            return Header::validateRequest($statusCode, $body);
        } catch (\Throwable $th) {
            return Header::validateRequest((int) 500, $th->getMessage());
        }
    }

    public static function createFolder($nameFolder, $userName, $userId) {
        try {
            
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('POST','folder',[
                'json' => [
                    'folderName'=> $nameFolder,
                    'parentFolderPath' => 'files/'.$userName
                    ]
            ]
        );
    
            $path = new Pathkit;
            $path->path_file =  'files/'.$userName.'/'.$nameFolder;
            $path->user_id = $userId;
            $path->save();
            $statusCode = $response->getStatusCode();
            return Header::validateRequest($statusCode, 'Folder created success');
        } catch (\Throwable $th) {
            return Header::validateRequest((int)500, $th->getMessage());
        }
    }

    public static function deleteFolder($folderPath) {
        try {
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('DELETE','folder',[
                'json' => [
                    'folderPath' => $folderPath,
                ]
            ]
        );
            $statusCode = $response->getStatusCode();
            return Header::validateRequest($statusCode, 'Pasta deletada com sucesso!');
        } catch (\Throwable $e) {
            return Header::validateRequest((int)500, $e->getMessage());
        }
    }

}