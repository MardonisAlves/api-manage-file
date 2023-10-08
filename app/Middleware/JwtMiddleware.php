<?php
namespace App\Middleware;

use Firebase\JWT\JWT;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Pecee\Http\Response;

class JwtMiddleware {

    protected $request;
    protected $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function handle(Request $request): void {
        $token = $request->getHeader('Authorization');

        if (!$token) {
            $response = new Response($request);
            $response->json(['error' => 'Unauthorized']);
            $response->send();
        }

        $token = str_replace('Bearer ', '', $token);
        $secretKey = getenv('SECRET_KEY');

        try {

        JWT::decode($token, $secretKey, ['HS256']);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('Token não fornecido.', 401);
        }
    }
}

$request = new Request();
$response = new Response($request);

$md = new JwtMiddleware($request, $response);
$md->handle($request);


