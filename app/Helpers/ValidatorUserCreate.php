<?php

namespace App\Helpers;
define('CONTENT_TYPE_JSON', 'application/json');
use Psr\Http\Message\RequestInterface as Request;
use Valitron\Validator as v;
use App\Helpers\Header;

 class ValidatorUserCreate{

    public  function __invoke(Request $request, $handler){
       
        try {
        $data =  $request->getBody();
        $post = json_decode($data, true);

        $v = new v($post);
        $v->rule('integer','endres.telefone');
        $v->rule('integer','endres.numero');
        $v->rule('integer','endres.cep');
        $v->rules([
            'required' => [
                'name', 'password', 'type', 'email',
                'endres.rua', 'endres.bairro', 'endres.telefone',
                'endres.numero', 'endres.cep' , 'endres.referencia'
                
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
