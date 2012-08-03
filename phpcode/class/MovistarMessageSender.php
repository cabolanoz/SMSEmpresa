<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once dirname(__FILE__) . '/../util/property.php';

class MovistarMessageSender {

    private $phonenumber;
    private $message;

    function __construct($_phonenumber, $_message) {
        $this->phonenumber = $_phonenumber;
        $this->message = $_message;
    }

    function sendMessage() {
        global $property;

        $request = new HttpRequest($property['MOVISTAR']['server'], HttpRequest::METH_GET);
        $request->addQueryData(array('shortcode' => $property['MOVISTAR']['shortcode'],
            'msisdn' => $property['MOVISTAR']['msisdn'] . $this->phonenumber,
            'telcoid' => $property['MOVISTAR']['telcoid'],
            'encoding' => $property['MOVISTAR']['encoding'],
            'smspart' => $property['MOVISTAR']['smspart'],
            'udh' => $property['MOVISTAR']['udh'],
            'body' => array($this->message),
            'systemID' => $property['MOVISTAR']['systemID']));

        try {
            return $request->send();
        } catch (HttpException $httpe) {
            if (isset($httpe->innerException)) {
                echo $httpe->innerException->getMessage();
                exit;
            }
        }

        return null;
    }

}

?>
