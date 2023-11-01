<?php
require_once './app/objects/Album.php';
require_once './api/config.php';
class Album_model
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . MYSQL_HOST .';dbname=' . MYSQL_DBASE .';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    public function getAlbums()
    {
        $query = $this->db->prepare('SELECT * FROM Albums');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFilteredAlbums($string)
    {
        $query = $this->db->prepare('SELECT * FROM Albums WHERE title LIKE ?');
        $query->execute(["%" . $string . "%"]);
        return $query->fetchAll(PDO::FETCH_CLASS, 'Album');
    }

    public function getAlbumById($id)
    {
        $query = $this->db->prepare('SELECT * FROM Albums WHERE id = ?');
        $query->setFetchMode(PDO::FETCH_CLASS, 'Album');
        $query->execute([$id]);
        return $query->fetch();
    }

    public function deleteAlbum($id)
    {
        try {
            $query = $this->db->prepare('DELETE FROM Albums WHERE id = ?');
            $query->execute([$id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function updateAlbum($id, Album $album, $parseUrl = null)
    {
        if(empty($parseUrl)) $parseUrl = FALSE;
        $img_url = ($parseUrl) ? $this->moveTempFile($album->getImgUrl()) : $album->getImgUrl();
        $query = $this->db->prepare('UPDATE `Albums` SET `title`= ?,`rel_date`=?,`review`=?,`artist`=?,`genre`=?,`rating`=? , `img_url` = ? WHERE id = ?');
        return $query->execute([$album->getTitle(),
                    (!empty($album->getRel_date())) ? $album->getRel_date() : null,
                    (!empty($album->getReview())) ? $album->getReview() : null,
                    $album->getArtist(),
                    (!empty($album->getGenre())) ? $album->getGenre() : null,
                    (!empty($album->getRating())) ? $album->getRating() : null, 
                    $img_url, 
                    $id]);
    }


    public function createAlbum($album)
    {
        try {
            $query = $this->db->prepare("INSERT INTO `Albums`(`title`, `rel_date`, `review`, `artist`, `genre`, `rating`, `img_url`) VALUES (?,?,?,?,?,?,?)");
            $query->execute(
                [
                    $album->getTitle(),
                    (!empty($album->getRel_date())) ? $album->getRel_date() : null,
                    (!empty($album->getReview())) ? $album->getReview() : null,
                    $album->getArtist(),
                    (!empty($album->getGenre())) ? $album->getGenre() : null,
                    (!empty($album->getRating())) ? $album->getRating() : null,
                    $this->moveTempFile($album->getImgUrl())
                ]
            );
            return $this->db->lastInsertId();
        } catch (\Throwable $th) {
            die($th);
        }
    }

    public function moveTempFile($url)
    {
        if (!empty($url)) {
            $filePath = "img/covers/album_cover_" . uniqid("", true) . "."
                . strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
            move_uploaded_file($url, $filePath);
            return $filePath;
        } else return " ";
    }
}
