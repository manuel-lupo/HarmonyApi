<?php
require_once "./api/controller/table.api.controller.php";
require_once "./api/helpers/token.helper.php";
require_once "./api/models/user.model.php";

class AuthApiController extends TableApiController{

    public function __construct(){
        parent::__construct();
        $this->model = new User_model();
    }

    /**
     * Summary of login
     * @param mixed $params
     * @return void
     */
    public function login($params =[]){
        $data = $this->getData();
        if(empty($data->password) or empty($data->name)){
            $this->view->response([
                "data" => "No se ha envida nada en los campos 'name' o 'password'",
                "status"=> "error",
            ],400);
        }

        $user = $this->model->getByUser($data->name);

        if(empty($user))
            $this->view->response([
                "data"=> 'El nombre de usuario indicado no corresponde con uno de nuestro sistema',
                'status'=> 'error'
            ],401);

        if(!password_verify($data->password, $user->password))
            $this->view->response([
                'data'=> 'La contraseña ingresada es incorrecta',
                'status'=> 'error'
            ],401);

        $token = TokenHelper::generate($user);
        $response = [
            'data'=> $token,
            'status' => 'logged'
        ];
        $this->view->response($response,200);
    }
}