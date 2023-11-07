<?php
require_once('./api/models/table.model.php');

class User_model extends Table_model{

    public function getUser($user_id) {
        $query = $this->db->prepare('SELECT * FROM Users WHERE id = ?');
        $query->execute([$user_id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}