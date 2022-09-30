<?php

class DBControl {

    private $_host;
    private $_user;
    private $_name;
    private $_pass;

    private $_connection;

    private function connectDB() {
        $_connection = mysqli_connect($this->_host, $this->_user, $this->_pass, $this->_name);
    }

    function DBControl($host, $user, $pass, $name, $connection) {
        $this->_host = $host;
        $this->_user = $user;
        $this->_name = $name;
        $this->_pass = $pass;

        $this->connectDB();
    }
}

?>