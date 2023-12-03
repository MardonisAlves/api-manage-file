<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Helpers\Header;
use App\ServicesHttp\UploadService;
use App\Helpers\Sanitize;
use Exception;
class UploadFileController extends BaseController
{
  public function createUpload()
  {
    try {
      $requestFile = $this->request->getUploadedFiles();
      $uploadedFile = $requestFile['file'];
  
      if (empty($requestFile['file'])) {
        return Header::validateRequest((int) 400, 'Por favor selecinar um file');
      } else {
        $nameFile = Sanitize::stringSanitize($uploadedFile->getClientFilename());
        $uploadedFile->moveTo(__DIR__ . './../../uploads/'.$nameFile);
        return UploadService::sendFile($uploadedFile->getClientFilename());
      }
    } catch (Exception $e) {
      return Header::validateRequest((int) 500, $e->getMessage());
    }

  }

  public function deleteUpload(){
    try {
      $paramValue = $this->request->getQueryParams();
      return UploadService::deleteFile(Sanitize::stringSanitize($paramValue['fileId']));
    } catch (\Throwable $th) {
      return Header::validateRequest((int) 500, $th->getMessage());
    }
  }

  public static function listUpload(){
    try {
      return UploadService::listFileUpload();
    } catch (Exception $e) {
      return Header::validateRequest((int)500, $e->getMessage());
    }
  }

  public function createFolder(){
    try {
      $data =  $this->request->getBody();
      $post = json_decode($data, true);
      return UploadService::createFolder(Sanitize::stringSanitize($post['folder']));

    } catch (\Throwable $th) {
      return Header::validateRequest((int)500, $th->getMessage());
    }
  }
}
