<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'DBConnection.php';

class MessageSender {

    private $phone;
    private $message;
    private $company;

    function __construct($_phone, $_message, $_company) {
        $this->phone = $_phone;
        $this->message = $_message;
        $this->company = $_company;
    }

    function insertMessage() {
        $sql = "INSERT INTO enviomensaje (numerotelefono, mensaje, fechaenvio, compania) VALUES ('" .
                '505' . $this->phone . "', '" .
                $this->message . "', '" .
                date('d/m/y H:i:s') . "', '" .
                $this->company . "');";

        $clazz = new DBConnection('localhost', 'root', '');
        $connection = $clazz->getConnection();
        
        if (mysql_query($sql, $connection))
            return true;
        else
            return false;
    }

}

?>