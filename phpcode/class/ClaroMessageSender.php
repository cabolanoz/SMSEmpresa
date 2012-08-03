<?php

/**
 * @author: César Bolaños [cbolanos]
 */
class ClaroMessageSender {

    private $phonenumber;
    private $message;

    function __construct($_phonenumber, $_message) {
        $this->phonenumber = $_phonenumber;
        $this->message = $_message;
    }

}

?>
