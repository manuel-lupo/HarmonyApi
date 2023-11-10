<?php
require_once './objects/Song.php';
require_once './api/models/table.model.php';
class songs_model extends Table_model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = 'Songs';
    }

    public function getSongs($input, $query_order, $per_page, $start_index, $sorted_by)
    {
        $limit = intval($per_page);
        $offset = intval($start_index);

        $query = $this->db->prepare("SELECT * FROM Songs WHERE title LIKE ? ORDER BY {$sorted_by} {$query_order} LIMIT {$limit} OFFSET {$offset}");
        $query->execute(["%$input%"]);
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
