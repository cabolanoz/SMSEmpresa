<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once dirname(__FILE__) . '/../util/property.php';
include_once ("smpp.class.php");

class ClaroMessageSender {

    function sendMessage($phonenumber, $message) {
        global $property;

        $src = $property['CLARO']['sourceAddress'];
        $dst = "505" . $phonenumber;

        $s = new smpp();
        $s->debug = 0;

        $s->open($property['CLARO']['server'], $property['CLARO']['port'], $property['CLARO']['systemID'], $property['CLARO']['password']);

        if ($s->send_long($src, $dst, $message) == true)
            return 'OK';
        else
            return null

        $s->close();
    }

}

?>
