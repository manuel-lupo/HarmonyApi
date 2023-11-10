<?php
require_once './api/config.php';
abstract class Table_model{
    protected $db;
    protected $table_name; //Definida por el hijo

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DBASE . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    public function columnExists($column_name)
    {
        $name = $this->getTableName();
        $query = $this->db->prepare("DESCRIBE $name");
        $query->execute();
        $columns = $query->fetchAll(PDO::FETCH_COLUMN);

        return in_array($column_name, $columns);
    }

    public function getTableName(){
        return $this->table_name;
    }
}