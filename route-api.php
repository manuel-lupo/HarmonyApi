<?php
try {
    require_once('./objects/Router.php');
require_once('./api/config.php');
require_once('./api/controller/album.api.controller.php');

// CONSTANTES PARA RUTEO
define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$router = new Router();

// rutas


$router->addRoute("albums" , "GET" , "AlbumApiController", "getAlbums");
$router->addRoute("albums/:ID" , "GET" , "AlbumApiController", "getAlbum");
$router->addRoute("albums" , "POST" , "AlbumApiController", "addAlbum");
$router->addRoute("albums/:ID" , "DELETE" , "AlbumApiController", "deleteAlbum");
$router->addRoute("albums/:ID" , "PUT" , "AlbumApiController", "updateAlbum");

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); 
} catch (\Throwable $th) {
    die($th);
}