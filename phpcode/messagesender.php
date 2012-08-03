<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once '/class/ClaroMessageSender.php';
require_once '/class/MovistarMessageSender.php';
require_once '/class/MessageSender.php';

$content = explode('|', $_GET['b']);
$recordnbr = count($content) - 1;

if ($recordnbr != 0) {
    $datas = array();
    $i = 0;
    foreach ($content as $value) {
        $valueexplode = explode('->', $value);
        if (sizeof($valueexplode) == 2) {
            $phone = $valueexplode[0];
            $message = $valueexplode[1];
            
            $clazz = null;
            if ($_GET['a'] == 'movistar')
                $clazz = new MovistarMessageSender($phone, $message);
            
            $data = null;
            $data->phone = $phone;
            $data->message = $message;
            
            $response = new HttpMessage($clazz->sendMessage());
            if ($response->getBody() != 'OK') {
                $datas[$i] = $data;
                $i++;
            } else {
                $messagesender = null;
                $messagesender = new MessageSender($phone, $message, $_GET['a']);
                $messagesender->insertMessage();
            }
        }
    }
    
    $response->success = true;
    $response->datas = $datas;
} else
    $response->success = false;

echo json_encode($response);
?>
