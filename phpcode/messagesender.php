<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once './class/ClaroMessageSender.php';
require_once './class/MovistarMessageSender.php';
require_once './class/MessageSender.php';

$content = explode('|', $_GET['datas']);
$recordnbr = count($content) - 1;

if ($recordnbr != 0) {
    $datas = array();
    $wrongdatas = array();

    //now is time to send the message
    if ($_GET['company_type'] == 'movistar')
        $sender = new MovistarMessageSender();
    else if ($_GET['company_type'] == 'claro')
        $sender = new ClaroMessageSender();

    foreach ($content as $value) {
        $valueexplode = explode('->', $value);
        if (sizeof($valueexplode) == 2) {
            $phone = $valueexplode[0];
            $message = strlen($valueexplode[1], 0, 160);
            $message = str_replace(array(' ', 'á', 'é', 'í', 'ó', 'ú'), array('%20', 'a', 'e', 'i', 'o', 'u'), $message);
            
            $data = new stdClass;
            $data->phone = $phone;
            $data->message = $message;

            $response = (($_GET['company_type'] == 'movistar') ? new HttpMessage($sender->sendMessage($data->phone, $data->message)) : $sender->sendMessage($data->phone, $data->message));
            if ($response->getBody() == 'OK') {
                $datas[] = $data;
            } else {
                $wrongdatas[] = $data;
            }
        }
    }

    MessageSender::insertMessages($datas, $_GET['company_type']);

    $response->success = true;
    $response->datas = $wrongdatas;
} else
    $response->success = false;

echo json_encode($response);
?>
