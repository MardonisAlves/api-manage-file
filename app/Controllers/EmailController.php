<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Header;
use App\Helpers\Sanitize;
use Exception;
use App\Utils\SendEmail;


class EmailController extends BaseController
{

    public function resetPassword()
    {
        try {
            $data = $this->request->getBody();
            $post = json_decode($data, true);
            $email = Sanitize::emailSanitize($post['email']);
            $email = SendEmail::sendMail($email);
            return Header::validateRequest(200, $email);
        } catch (Exception $e) {
            return Header::validateRequest((int) 500, $e->getMessage());
        }
    }
}

