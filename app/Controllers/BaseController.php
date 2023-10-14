<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    protected $request;
    protected $response;
    protected $db;

    public function __construct($db, Request $request, Response $response)
    {
        $this->db = $db;
        $this->request = $request;
        $this->response = $response;
    }
}
