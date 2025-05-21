<?php

namespace app\models\drivers;

use mysqli;

class ConexDB
{
    private $host = 'localhost';
    private $user = 'root';
    private $pwd = '';
    private $nameDB = 'proyecto_2_db';

    private $conex = null;

    public function getConex()
    {
        return $this->conex;
    }
    
    public function __construct()
    {
        $this->conex = new mysqli(
            $this->host,
            $this->user,
            $this->pwd,
            $this->nameDB
        );
    }

    public function execSQL($sql){
        return $this->conex->query($sql);
    }

    public function close(){
        $this->conex->close();
    }

}