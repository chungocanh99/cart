<?php

class Database {
    public $host = "localhost";

    public $user = "root";

    public $password="";

    public $database = "simple1_shop";

    public $connection;


    public function __construct()
    {
        $this->connection=$this->connectDatabase();
    }
    /*
    * phương thức kết nối đến cơ sở dữ liệu
    */
    public function connectDatabase() {
        $connection = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $connection;
    }

    public function runQuery($sql) {
        $data=array();
        $result = mysqli_query($this->connection,$sql);


        while($row=mysqli_fetch_assoc($result)) {

            $data[]=$row;


        }

        return $data;
    }

    public function numRows($sql) {
        $result = mysqli_query($this->connection,$sql);
        $count = mysqli_num_rows($result);
        return $count;
    }

}