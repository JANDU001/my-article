<?php

require_once 'constants.php';

class DB {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "myarticles";

    public function getConnection() {
        $conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}

?>
