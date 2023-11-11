<?php
try {
    require_once('./objects/Router.php');
require_once('./api/config.php');
require_once('./api/controller/album.api.controller.php');
require_once ('./api/controller/song.api.controller.php');
require_once "./api/controller/auth.api.controller.php";

/**
 * @OA\Info(title="HarmonyHubAPI", version="1")
 */



// CONSTANTES PARA RUTEO
define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

$router = new Router();

// rutas
/**
 * @OA\POST(
 *     path="/login",
 *     @OA\Response(response="200", description="Login untilizado para obtener un token que se usara para autenticar al usuario en las operaciones de alta baja y modificacion")
 * )
 */
$router->addRoute("auth", "POST", "AuthApiController", "login");

$router->addRoute("albums" , "GET" , "AlbumApiController", "getAlbums");
$router->addRoute("albums/:ID" , "GET" , "AlbumApiController", "getAlbum");
$router->addRoute("albums" , "POST" , "AlbumApiController", "addAlbum");
$router->addRoute("albums/:ID" , "DELETE" , "AlbumApiController", "deleteAlbum");
$router->addRoute("albums/:ID" , "PUT" , "AlbumApiController", "updateAlbum");

$router->addRoute("songs", "GET", "songsApiController", "getSongs");
$router->addRoute("songs/:ID", "GET", "songsApiController", "getSong");
$router->addRoute("songs/:ID", "DELETE", "songsApiController", "deleteSong");
$router->addRoute("songs", "POST", "songsApiController", "addSong");
$router->addRoute("songs/:ID", "PUT", "songsApiController", "updateSong");

//run
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
} catch (\Throwable $th) {
    die($th);
}