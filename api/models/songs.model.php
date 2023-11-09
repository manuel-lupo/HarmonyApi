<?php
require_once './objects/Song.php';
require_once './api/models/table.model.php';
class Songs_model extends Table_model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'Songs';
    }

    public function getSongs()
    {
        $query = $this->db->prepare('SELECT * FROM Songs');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS, 'Song');
    }

    public function getSongById($id)
    {
        $query = $this->db->prepare('SELECT * FROM Songs WHERE id= ?');
        $query->execute([$id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'Song');
        return $query->fetch();
    }
    public function getSongsByAlbum($id)
    {
        $query = $this->db->prepare('SELECT * FROM Songs WHERE album_id = ?');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Song');
    }

    public function getFilteredSongs($string)
    {
        $query = $this->db->prepare('SELECT * FROM Songs WHERE title LIKE ?');
        $query->execute(["%" . $string . "%"]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Song');
    }


    public function addSong($song)
    {
        $query = $this->db->prepare('INSERT INTO `Songs`(`title`, `rel_date`, `album_id`, `lyrics`) VALUES (?,?,?,?)');
        $query->execute([$song->title, $song->rel_date, $song->album_id, $song->lyrics]);
        return $this->db->lastInsertId();
    }

    public function deleteSong($id)
    {
        $query = $this->db->prepare('DELETE FROM `Songs` WHERE id = ?');
        return $query->execute([$id]);
        
    }

    public function updateSong($id, $song)
    {
        $query = $this->db->prepare('UPDATE `Songs` SET `title`= ?,`rel_date`= ?,`lyrics`= ? WHERE id = ?');
        return $query->execute([$song->title, $song->rel_date, $song->album_id, $song->lyrics]);
    }
}
