<?php

/**
 * @author: César Bolaños [cbolanos]
 */
if ($_FILES['txtfile']["error"] == 0) {
    $filename = 'upload/' . $_FILES['txtfile']['name'];
    move_uploaded_file($_FILES["txtfile"]["tmp_name"], $filename);
    $fileopen = fopen($filename, 'r');
    $filecontent = fread($fileopen, filesize($filename));
    fclose($fileopen);

    $filetext = explode(PHP_EOL, $filecontent);

    $counter = 0;
    $datas = array();
    for ($i = 0; $i < sizeof($filetext); $i++) {
        $fileline = explode("\t", $filetext[$i]);
        if (sizeof($fileline) == 2) {
            $filephone = $fileline[0];
            if (strlen($filephone) != 8)
                continue;
            
            $filemessage = trim($fileline[1]);
            $data = null;
            $data->id = $counter + 1;
            $data->phone = $filephone;
            $data->message = $filemessage;
            $datas[$i] = $data;
            
            $counter++;
        }
    }

    $response->success = true;
    $response->datas = $datas;
} else
    $response->success = false;

echo json_encode($response);
?>
