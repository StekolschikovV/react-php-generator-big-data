<?php
/**
 * Created by PhpStorm.
 * User: steko
 * Date: 22.06.2018
 * Time: 9:32
 */

class DB
{

    private $connection;
    private static $_instance;
    private $dbhost = "localhost"; // Ip Address of database if external connection.
    private $dbuser = "root"; // Username for DB
    private $dbpass = ""; // Password for DB
    private $dbname = "task1"; // DB Name
    private $dbtable = "data"; // DB Name

    public static function getInstance(){
        if(!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct() {
        try{
            $this->connection = new PDO('mysql:host='.$this->dbhost.';dbname='.$this->dbname, $this->dbuser, $this->dbpass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Failed to connect to DB: ". $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->connection;
    }

    public function db_query($sql, $params = [], $get = false){

        $db = $this->getInstance();
        $conn = $db->getConnection();

        if(!$get){
            $query = $conn->prepare($sql);
            $query->execute($params);

            $this->db_check_error($query);

            return $query;
        } else {
//            var_dump($sql);
            return $conn->query($sql)->fetchAll();
        }

    }

    public function db_check_error($query){
        $info = $query->errorInfo();

        if($info[0] != PDO::ERR_NONE){
            exit($info[2]);
        }
    }

    public function upload($value){
        $this->db_query("INSERT INTO $this->dbtable (value) VALUES (:t)", [
            't' => $value
        ]);
    }

    public function select(){
        $res = $this->db_query("SELECT * FROM $this->dbtable LIMIT 100", [], true);
        $this->db_query("DELETE FROM $this->dbtable LIMIT 100", []);
        return $res;

    }

}

//
//$DB = new DB();
//
//$DB->upload(1123333);

