<?php
namespace App\Route;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Controllers\EmailController;
use App\Controllers\UploadFileController;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\JwtMiddleware;
use App\Helpers\ValidatorUserCreate;
use App\Dependeces\Dependeces;


class AppRoutes
{
    private $app;

    public function __construct()
    {
        $this->app = Dependeces::dependeces();
        $this->configureRoutes();
    }

    private function configureRoutes()
    {
        $this->configureAuthRoutes();
        $this->configureUserRoutes();
        $this->configureUploadRoutes();
        $this->configureHomeRoutes();
        $this->configureEmailRoutes();

        $this->app->addErrorMiddleware(true, true, true);
        $this->app->run();
    }

    private function configureAuthRoutes()
    {
        $this->app->get('/', function ($request, $response) {
          echo phpinfo();
        });
    }

    private function configureHomeRoutes()
    {
        $this->app->post('/auth', function ($request, $response) {
            $authController = new AuthController($request, $response);
            return $authController->auth();
        });
    }

    private function configureUserRoutes()
    {
        $this->app->group('/users', function (RouteCollectorProxy $group) {
            $group->get('/findall', function ($request, $response) {
                $userController = new UserController($request, $response);
                return $userController->findAll();
            });
            $group->post('/create', function ($request, $response) {
                $userController = new UserController($request, $response);
                return $userController->create();
            })->add(new ValidatorUserCreate());
        })->add(new JwtMiddleware());
    }

    private function configureUploadRoutes()
    {
        $this->app->group('/upload', function (RouteCollectorProxy $group) {
            $group->post('/create', function ($request, $response) {
                $uploadController = new UploadFileController($request, $response);
                return $uploadController->createUpload();
            });
            $group->delete('/delete', function ($request, $response) {
                $uploadController = new UploadFileController($request, $response);
                return $uploadController->deleteUpload();
            });
            $group->get('/list', function ($request, $response) {
                $uploadController = new UploadFileController($request, $response);
                return $uploadController->listUpload();
            });
            $group->post('/folder', function ($request, $response) {
                $uploadController = new UploadFileController($request, $response);
                return $uploadController->createFolder();
            });

            $group->delete('/folder', function ($request, $response) {
                $uploadController = new UploadFileController($request, $response);
                return $uploadController->deleteFolder();
            });

            $group->post('/videos', function ($request, $response) {
                $uploadController = new UploadFileController($request, $response);
                return $uploadController->createUpload();
            });
        })->add(new JwtMiddleware());
    }

    private function configureEmailRoutes()
    {
        $this->app->group('/email', function (RouteCollectorProxy $group) {
            $group->post('/resetPassword', function ($request, $response) {
                $userController = new EmailController($request, $response);
                return $userController->resetPassword();
            });
        });
    }
}




