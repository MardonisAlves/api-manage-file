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
      $paramValue = $this->request->getQueryParams();
      $uploadedFile = $requestFile['file'];
      $folder = Sanitize::stringSanitize($paramValue['folder']);
      $userId = Sanitize::stringSanitize($paramValue['userId']);
  
      if (empty($requestFile['file']) || empty($paramValue['folder']) || empty($paramValue['userId'])) {
        return Header::validateRequest((int) 400, 'Por favor selecinar um file com o nome da pasta e id user');
      } else {
        $nameFile = Sanitize::stringSanitize($uploadedFile->getClientFilename());
        $uploadedFile->moveTo(__DIR__ . './../../uploads/'.$nameFile);
        return UploadService::sendFile($uploadedFile->getClientFilename(), $folder, $userId);
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
      $path =Sanitize::stringSanitize($post['folder']);
      $name =  Sanitize::stringSanitize($post['username']);
      $userId =  Sanitize::stringSanitize($post['userId']);
      return UploadService::createFolder($path, $name, $userId);
    } catch (\Throwable $th) {
      return Header::validateRequest((int)500, $th->getMessage());
    }
  }

  public function deleteFolder(){
    try {
      $data =  $this->request->getBody();
      $post = json_decode($data, true);
      return UploadService::deleteFolder($post['folderPath']);
    } catch (Exception $e) {
      return Header::validateRequest((int)500, $e->getMessage());
    }
  }
}
