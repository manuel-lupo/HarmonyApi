<?php
require_once './api/models/songs.model.php';
require_once './api/controller/table.api.controller.php';
require_once './api/views/json.view.php';

class songApiController extends TableApiController {
    private $songsModel;

    public function __construct(){
        parent::__construct();
        $this->songsModel = new songs_model();
    }

    function getSongs($params = []) {
        $songs = $this->songsModel->getSongs();
        return $this->view->response($songs, 200);
    }

    function getSong($params = []){
        $song = $this->songsModel->getSongById($params[":ID"]);
        return $this->view->response($song, 200);
    }

    public function deleteSong($params = []) {
        $song_id = $params[':ID'];
        if(empty($song_id)){
            $this->view->response('no se ingresó un id', 400);
        }
        $song = $this->songsModel->getSongById($song_id);
        if ($song) {
            if($this->songsModel->deleteSong($song_id);){
                $this->view->response("la canción con id= $song_id se eliminó con éxito", 200);
            }else
            $this->view->response('la canción no se pudo eliminar', 500);
        }
        else 
            $this->view->response("la canción con id= $song_id no existe", 404);
    }

    public function addSong($params = []) {   
         $body = $this->getData();
        
         $song = new song();
         $song->setValues($data->title, $data->rel_date, $data->album_id, $data->lyrics);

         $song_id = $this->songsModel->addSong($song);

         $added_song = $this->songsModel->getSongById($song_id);

         if($added_song){
            $this->view->response($added_song, 201);
         }else
         $this->view->response("La canción no fué creada", 500);
    }
  
}
