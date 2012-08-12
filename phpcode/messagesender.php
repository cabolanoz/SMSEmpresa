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
    
    //now is time to send the message
    
    if ($_GET['company_type'] == 'movistar')
                $sender = new MovistarMessageSender();
            else if($_GET['company_type'] == 'claro'){
                //claro implementation for sender
            }
    
    foreach ($content as $value) {
        $valueexplode = explode('->', $value);
        if (sizeof($valueexplode) == 2) {
            $phone = $valueexplode[0];
            $message = $valueexplode[1];
            
            
            $data = new stdClass;
            $data->phone = $phone;
            $data->message = $message;
            
            
            $response = new HttpMessage($sender->sendMessage($data->phone, $data->message));
            if ($response->getBody() == 'OK') {
                //flag as correct   
                
            } else{
                //flag as incorrect
            }
            
             
            $datas[] = $data;
            
        }
    }
            
            
    MessageSender::insertMessages($datas,$_GET['company_type'] );
    
    $response->success = true;
    $response->datas = $datas;
} else
    $response->success = false;

echo json_encode($response);
?>
