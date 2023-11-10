<?php

abstract class TableApiController{

    protected $model;
    protected $view;

    protected $data;

    public function __construct()
    {
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    protected function getData()
    {
        return json_decode($this->data);
    }

    protected function verifyToken(){
        $token = TokenHelper::getTokenFromHeaders();

        if (empty($token))
            $this->view->response([
                "data" => "No se cuenta con un token para verificar identidad",
                "status" => "error",
            ], 401);
            $verification = TokenHelper::verify($token);
        if ($verification !== true)
            $this->view->response([
                "data" => $verification->getMessage(),
                "status" => "error",
            ], $verification->getCode());
    }

}