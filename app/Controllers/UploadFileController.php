<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Helpers\Header;
use App\Model\Pathkit;
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
        return UploadService::sendFile($uploadedFile, $folder, $userId, $nameFile);
      }
    } catch (Exception $e) {
      return Header::validateRequest((int) 500, $e->getMessage());
    }

  }

  public function deleteUpload(){
    try {
      $paramValue = $this->request->getQueryParams();
      $fileId= Sanitize::stringSanitize($paramValue['fileId']);
      $uploadId= Sanitize::stringSanitize($paramValue['upload_id']);
      return UploadService::deleteFile($fileId, $uploadId);
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

      $pathFile =  Pathkit::where('path_file', 'files/'.$name.'/'.$path)->get();
      $pathDecode = json_decode($pathFile, true);
      
      if(count($pathDecode) > 0){
        return Header::validateRequest((int)200, 'A pasta com este nome ja existe');
      }

      return UploadService::createFolder($path, $name, $userId);
    } catch (\Throwable $th) {
      return Header::validateRequest((int)500, $th->getMessage());
    }
  }

  public function deleteFolder(){
    try {
      $data =  $this->request->getBody();
      $post = json_decode($data, true);
      return UploadService::deleteFolder($post['folderPath'], $post['pathId']);
    } catch (Exception $e) {
      return Header::validateRequest((int)500, $e->getMessage());
    }
  }
}
