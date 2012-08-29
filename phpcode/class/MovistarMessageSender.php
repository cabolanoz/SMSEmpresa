<?php

/**
 * @author: Cesar Bolaños [cbolanos]
 */
require_once dirname(__FILE__) . '/../util/property.php';

class MovistarMessageSender {

    function sendMessage($phonenumber, $message) {
        global $property;

        $request = new HttpRequest($property['MOVISTAR']['server'], HttpRequest::METH_GET);
        $request->addQueryData(array('shortcode' => $property['MOVISTAR']['shortcode'],
            'msisdn' => $property['MOVISTAR']['msisdn'] . $phonenumber,
            'telcoid' => $property['MOVISTAR']['telcoid'],
            'encoding' => $property['MOVISTAR']['encoding'],
            'smspart' => $property['MOVISTAR']['smspart'],
            'udh' => $property['MOVISTAR']['udh'],
            'body' => array($message),
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
