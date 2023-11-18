<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Header;
use App\ServicesHttp\UploadService;
use Exception;

class UploadFileController extends BaseController
{
  public function createUpload()
  {
    try {

      $requestFile = $this->request->getUploadedFiles();
      $uploadedFile = $requestFile['file'];
      if (!empty($uploadedFiles['file'])) {
        return Header::validateRequest((int) 400, 'Por favor selecinar um file');
      } else {
        $uploadedFile->moveTo(__DIR__ . './../../uploads/' . $uploadedFile->getClientFilename());
        return UploadService::sendFile($uploadedFile->getClientFilename());
      }

    } catch (Exception $e) {
      return Header::validateRequest((int) 500, $e->getMessage());
    }

  }

  public function deleteUpload(){
    try {
      $paramValue = $this->request->getQueryParams();
      return UploadService::deleteFile($paramValue);
    } catch (\Throwable $th) {
      return Header::validateRequest((int) 500, $th->getMessage());
    }
  }
}