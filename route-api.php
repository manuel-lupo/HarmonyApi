<?php
try {
    require_once('./objects/Router.php');
require_once('./api/config.php');
require_once('./api/controller/album.api.controller.php');
require_once ('./api/controller/song.api.controller.php');

// CONSTANTES PARA RUTEO
define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$router = new Router();

// rutas


$router->addRoute("albums" , "GET" , "AlbumApiController", "getAlbums");
$router->addRoute("albums/:ID" , "GET" , "AlbumApiController", "getAlbum");
$router->addRoute("albums" , "POST" , "AlbumApiController", "addAlbum");
$router->addRoute("albums/:ID" , "DELETE" , "AlbumApiController", "deleteAlbum");
$router->addRoute("albums/:ID" , "PUT" , "AlbumApiController", "updateAlbum");

$router->addRoute('songs' , 'GET', 'songApiController', 'getSongs');
$router->addRoute('songs/:ID', 'GET', 'songApiController', 'getSong');
$router->addRoute('songs', 'POST', 'songApiController', 'addSong');
$router->addRoute('songs/:ID', 'DELETE', 'songApiController', 'deleteSong');
$router->addRoute('songs/:ID', 'POST', 'songApiController', 'updateSong');

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); 
} catch (\Throwable $th) {
    die($th);
}