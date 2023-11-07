<?php
require_once("./api/models/album.model.php");
require_once("./api/controller/table.api.controller.php");
require_once("./api/views/json.view.php");

class AlbumApiController extends TableApiController 
{
    public function __construct(){
        parent::__construct();
        $this->model = new Album_Model();
    }

    private function getDataInAlbum($album, $data)
    {
        if (!empty($data->artist))
            $album->setArtist($data->artist);
        if (!empty($data->title))
            $album->setTitle($data->title);
        if (!empty($data->img_url))
            $album->setImgUrl($data->img_url);
        if (!empty($data->review))
            $album->setReview($data->review);
        if (!empty($data->rel_date))
            $album->setRelDate($data->rel_date);
        if (!empty($data->rating))
            $album->setRating($data->rating);
        if (!empty($data->genre))
            $album->setGenre($data->genre);
    }

    public function getAlbums($params = [])
    {
        $input = !empty($_GET["search_input"]) ? $_GET["search_input"] : "";
        $min_rating = !empty($_GET["min_rating"]) ? (float)$_GET["min_rating"] : 0;
        $sorted_by = (!empty($_GET['sort_by']) && $this->model->columnExists($_GET['sort_by'])) ? $_GET['sort_by'] : "rel_date";
        $order = (!empty($_GET['order']) && $_GET['order'] == 1) ? 1 : 0;

        $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $per_page = !empty($_GET['per_page']) ? (int)$_GET['per_page'] : 10; 
        $start_index = ($page - 1) * $per_page;
    
        $albums = $this->model->getAlbums($min_rating, $input, $order, $sorted_by, $start_index, $per_page);
        
        if ($albums) {
            if(count($albums) !== 0) 
                $this->view->response($albums, 200);
            else
                $this->view->response("No se encontraron resultados con la búsqueda de: {$input}", 404);    
        } else {
            $this->view->response("Ha ocurrido un error y no se puede completar la busqueda", 500);
        }
    }
    

    public function getAlbum($params = [])
    {
        $id = $params[':ID'];
        if (empty($id))
            $this->view->response('No se ha proporcionado un id', 400);

        $album = $this->model->getAlbumById($id);
        if ($album)
            $this->view->response($album, 200);
        else
            $this->view->response("El album con el id={$id} no existe", 404);
    }

    public function deleteAlbum($params = [])
    {
        $id = $params[':ID'];
        if (empty($id))
            $this->view->response('No se ha proporcionado un id', 400);
        $album = $this->model->getAlbumById($id);
        if ($album) {
            if ($this->model->deleteAlbum($id))
                $this->view->response("El album fue borrado con exito.", 200);
            else
                $this->view->response("Hubo un error y no se pudo eliminar el album", 500);
        } else
            $this->view->response("El album con el id={$id} no existe", 404);
    }

    public function addAlbum($params = [])
    {
        $data = $this->getData();

        if (empty($data->title) or empty($data->artist) or empty($data->rating))
            $this->view->response("Falto ingresar algun dato", 400);

        $album = new Album();
        $album->setValues(
            $data->title,
            (!empty($data->rel_date)) ? $data->rel_date : null,
            (!empty($data->review)) ? $data->review : null,
            $data->artist,
            (!empty($data->genre)) ? $data->genre : null,
            (!empty($data->rating)) ? $data->rating : null,
            $data->img_url
        );
        $id = $this->model->createAlbum($album);

        $album = $this->model->getAlbumById($id);
        if ($album)
            $this->view->response($album, 201);
        else
            $this->view->response("El album no fue creado", 500);
    }

    public function updateAlbum($params = [])
    {
        $id = $params[':ID'];
        if (empty($id))
            $this->view->response('No se ha proporcionado un id', 400);

        $data = $this->getData();
        $album = $this->model->getAlbumById($id);

        if ($album) {
            $this->getDataInAlbum($album, $data);
            if ($this->model->updateAlbum($id, $album))
                $this->view->response($album, 200);
            else
                $this->view->response('Ha ocurrido un error y no  se pudo actualizar el album', 500);
            return;
        }

        $this->view->response("El album con el id={$id} no existe", 404);
    }
}
