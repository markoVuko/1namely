<?php

namespace App\Models;

class DB {
    private $server;
    private $database;
    private $username;
    private $password;

    public $conn;

    public function __construct($server, $database, $username, $password){
        $this->server = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password; 

        $this->connect();
    }

    private function connect(){
        $this->conn = new \PDO("mysql:host={$this->server};dbname={$this->database};charset=utf8", $this->username, $this->password);
        
        $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function executeQuery($query){
        // bilo koji SELECT upit bez WHERE 
        return $this->conn->query($query)->fetchAll();
    }

    public function executeQueryWithParams($query, $params){
        $prepare = $this->conn->prepare($query); // SELECT * WHERE naziv = ? OR opis = ?
        // $params = ['dads', 'dasd']
        $prepare->execute($params);
        return $prepare->fetchAll();
    }
}