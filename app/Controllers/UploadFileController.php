<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Header;
use App\Utils\UploadUtil;
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
        return UploadUtil::sendFile($uploadedFile->getClientFilename());
      }

    } catch (Exception $e) {
      return Header::validateRequest((int) 500, $e->getMessage());
    }

  }
}