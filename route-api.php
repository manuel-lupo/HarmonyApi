<?php
require_once('./objects/Router.php');
require_once('./api/config.php');
require_once('./api/controller/album.api.controller.php');

// CONSTANTES PARA RUTEO
define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$router = new Router();

// rutas

$r->addRoute("/albums" , "GET" , "AlbumApiController", "getAlbums");

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); 