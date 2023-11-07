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

    function addSong(){
        
    }
  
}
