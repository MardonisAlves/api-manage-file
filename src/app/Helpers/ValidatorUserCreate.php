<?php
namespace App\Helpers;
use Psr\Http\Message\RequestInterface as Request;
use Valitron\Validator as v;
use App\Helpers\Header;

 class ValidatorUserCreate{

    public  function __invoke(Request $request, $handler){
       
        try {
        $data =  $request->getBody();
        $post = json_decode($data, true);

        $v = new v($post);
        $v->rules([
            'required' => [
                'name', 'password', 'type', 'email'
            ],
            'length' => [
                ['password', 6]
            ]
        ]);
      
        
        if($v->validate()) {
         return $handler->handle($request);
        }else{
            return Header::validateUser($v->errors(), 400);
        }
    } catch (\UnexpectedValueException $e) {
        return Header::validateUser($e, 500);
    }
    }
}
