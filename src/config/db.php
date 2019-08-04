<?php

class db
{
    private $username = 'root';
    private $password = '';
    private $host = "localhost";
    private $dbName = 'slim_api';

    public function connect()
    {
        $dbConnection = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }

}



// try {
//     $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully";
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }