<?php
namespace App\ServicesHttp;

use App\Helpers\Header;
use App\Utils\GuzzHttp;
use GuzzleHttp\Exception\ClientException;
use App\Model\Upload;
use App\Model\Pathkit;
use Exception;

class UploadService
{

    public static function sendFile($base64, $path, $userId, $nameFile)
    {
        try {
            $base64Content = base64_encode($base64->getStream()->getContents());
            $client = GuzzHttp::ClientHttp();


            $response = $client->request('POST', 'files/upload', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => $base64Content,
                        'headers' => ['Content-Type' => 'application/json'],

                    ],
                    [
                        'name' => 'fileName',
                        'contents' => $nameFile,
                    ],
                    [
                        'name' => 'folder',
                        'contents' => $path,
                    ],
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents());
            $upload = new Upload;
            $upload->user_id = $userId;
            $upload->url = $body->url;
            $upload->path = $body->filePath;
            $upload->file_name = $body->name;
            if (isset($body->thumbnailUrl)) {
                $upload->thumbnailUrl = $body->thumbnailUrl;
            } else {
                $upload->thumbnailUrl = '';
            }
            $upload->fileId = $body->fileId;
            $upload->save();

            $Pathkit = new Pathkit;
            $Pathkit->path_file = $path;
            $Pathkit->upload_id = $upload->id;
            $Pathkit->save();

            return Header::validateRequest($statusCode, $body);
        } catch (ClientException $e) {
            return Header::validateRequest((int) 500, 'Erro durante o upload: ' . $e->getMessage());
        }
    }

    public static function deleteFile($fileId, $uploadId)
    {
        try {
            $client = GuzzHttp::ClientHttp();
            $client->request('DELETE', "files/{$fileId}");
            Upload::where('id', $uploadId)->delete();
            return Header::validateRequest((int) 200, 'File deletado com sucesso');
        } catch (\Throwable $th) {
            return Header::validateRequest((int) 500, $th->getMessage());
        }
    }

    public static function listFileUpload()
    {
        try {
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('GET', 'files');
            $body = json_decode($response->getBody()->getContents());
            $statusCode = $response->getStatusCode();

            return Header::validateRequest($statusCode, $body);
        } catch (Exception $e) {
            return Header::validateRequest((int) 500, $e->getMessage());
        }
    }

    public static function deleteFileUpload($nameFolder)
    {
        try {
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('POST', 'folder', ['folderName' => $nameFolder]);
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents());
            
            return Header::validateRequest($statusCode, $body);
        } catch (\Throwable $th) {
            return Header::validateRequest((int) 500, $th->getMessage());
        }
    }

    public static function createFolder($nameFolder, $userName, $userId)
    {
        try {

            $client = GuzzHttp::ClientHttp();
            $response = $client->request('POST', 'folder', [
                'json' => [
                    'folderName' => $nameFolder,
                    'parentFolderPath' => 'files/' . $userName
                ]
            ]
            );
            $statusCode = $response->getStatusCode();
            return Header::validateRequest($statusCode, 'Folder created success');
        } catch (\Throwable $th) {
            return Header::validateRequest((int) 500, $th->getMessage());
        }
    }

    public static function deleteFolder($folderPath, $pathId)
    {
        try {
            $client = GuzzHttp::ClientHttp();
            $response = $client->request('DELETE', 'folder', [
                'json' => [
                    'folderPath' => $folderPath,
                ]
            ]
            );
            Pathkit::where('id', $pathId)->delete();

            $statusCode = $response->getStatusCode();
            return Header::validateRequest(200, 'Pasta deletada com sucesso!');
        } catch (\Throwable $e) {
            return Header::validateRequest((int) 500, $e->getMessage());
        }
    }

}
