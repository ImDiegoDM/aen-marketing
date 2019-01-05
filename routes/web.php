<?php

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *  title="Marketing", 
 *  version="1"
 * )
 */

$router->get('/', function () use ($router) {
    return view('swagger');
});

/**
 * @OA\Post(
 *   path="/v1/api/marketing",
 *   summary="Envia um email marketing",
 *   @OA\Parameter(
 *     name="name",
 *     in="body",
 *     required=true,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="email",
 *     in="body",
 *     required=true,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\Parameter(
 *     name="template",
 *     in="body",
 *     required=true,
 *     @OA\Schema(type="string")
 *   ),
 *   @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="template",
 *                     type="string"
 *                 ),
 *                 example={"name": "Douglas", "email": "doug@gmail.com","template":"welcome"}
 *             )
 *         )
 *     ),
 *   @OA\Response(
 *     response=200,
 *     description="Confirmação de envio de email marketing",
 *   )
 * )
 */

$router->group(['prefix' => '/v1/api'], function ($app) {
    $app->post('/marketing', function (Request $request)  {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'template' => 'required'
        ]);

        $element['id'] = random_int(0, 20);
        $element['name'] = $request->name;
        $element['email'] = $request->email;
        $element['template'] = $request->template;

        
        return response(["message"=>"Enviado com sucesso","saved"=>$element],201);
    });

    $app->get('/marketing', function (Request $request)  {
        $faker = Faker\Factory::create();

        $sended = [];

        for ($i=0; $i < 10; $i++) {
            array_push($sended,[
                "id"=>$i+1,
                "name"=>$faker->name,
                "email"=>$faker->email,
                "template"=>"welcome"
            ]);
        }
        
        return response($sended,200);
    });
});
