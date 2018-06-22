<?php

header('Access-Control-Allow-Origin: *'); 

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

class Api
{

    public $db = null;
    public $math = null;

    public function __construct()
    {
        $this->db = new DB();
        $this->math = new Math();

        $this->getRequest();
    }

    public function getRequest()
    {
        $command = $_GET["command"] ? $_GET["command"] : null ;

        // http://profit-center-fx/1/api/index.php?command=set&min=1&max=5&count=100
        if($command == 'set'){
            $this->actionSet();
        }

        // http://profit-center-fx/1/api/index.php?command=get
        elseif  ($command == 'get'){
          echo json_encode($this->db->select(), JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
        }
    }

    public function actionSet()
    {
        $min = ($_GET["min"] && $_GET["min"] > 0 ) || null;
        $max = ($_GET["max"] && $_GET["max"] > 0 && $_GET["max"] > $_GET["min"] )  || null;
        $count = ($_GET["count"] && $_GET["count"] > 0 ) || null;

        if($min && $max && $count) {
            $min = $_GET["min"];
            $max = $_GET["max"];
            $count = $_GET["count"];

            for($i = 0; $i < $count; $i++){
                $this->db->upload($this->math->generator($min, $max));
            }
        } else {
            echo 'no data';
        }
    }
}

new Api();