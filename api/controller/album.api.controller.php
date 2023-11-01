<?php
require_once("./models/album.model.php");
require_once("./api/json.view.php");

class AlbumApiController
{

    private $model;
    private $view;

    private $data;

    public function __construct()
    {
        $this->model = new Album_Model();
        $this->view = new JSONView();
        $this->data = file_get_contents("php://input");
    }

    private function getData()
    {
        return json_decode($this->data);
    }

    public function  getAlbums($params = [])
    {
        if (empty($params)) {
            $albums = $this->model->getAlbums();
            $this->view->response($albums, 200);
            return;
        } else {
            $albums = $this->model->getFilteredAlbums($params[":search-input"]);
            if ($albums) {
                $this->view->response($albums, 200);
                return;
            } else {
                $this->view->response("No se encontraron resultados con la busqueda de: {$params}", 404);
            }
        }
    }

    public function getAlbum($params = [])
    {
        $id = $params[':ID'];

        $album = $this->model->getAlbumById($id);
        if ($album)
            $this->view->response($album, 200);
        else
            $this->view->response("El album con el id={$id} no existe", 404);
    }

    public function deleteAlbum($params = [])
    {
        $id = $params[':ID'];
        $album = $this->model->getAlbumById($id);
        if ($album) {
            $this->model->deleteAlbum($id);
            $this->view->response("El album fue borrado con exito.", 200);
        } else
            $this->view->response("El album con el id={$id} no existe", 404);
    }

    public function addAlbum($params = [])
    {
        $data = $this->getData();
        $album = new Album();
        $album->setValues($data->title, $data->rel_date , $data->review , $data->artist , $data->genre, $data->rating , $data->img_url) ;
        $id = $this->model->createAlbum($album);

        $album = $this->model->getAlbumById($id);
        if ($album)
            $this->view->response($album, 200);
        else
            $this->view->response("El album no fue creado", 500);
    }

    public function updateAlbum($params = [])
    {
        $id = $params[':ID'];
        $data = $this->getData();

        $album = new Album();
        $album->setValues($data->title, $data->rel_date , $data->review , $data->artist , $data->genre, $data->rating , $data->img_url) ;
        if ($album) {
            $this->model->updateAlbum($id, $album);
            $this->view->response("El album fue modificado con exito.", 200);
        } else
            $this->view->response("El album con el id={$id} no existe", 404);
    }
}
