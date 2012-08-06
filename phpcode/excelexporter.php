<?php

/**
 * @author: César Bolaños [cbolanos]
 */
function cleanData(&$str) {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"';
}

$filename = "smsempresa_" . date('Ymd') . ".xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");
header("Pragma: no-cache");
header("Expires: 0");

$content = explode('|', $_GET['a']);
$recordnbr = count($content) - 1;

if ($recordnbr != 0) {
    $datas = array();
    $i = 0;
    foreach ($content as $value) {
        $valueexplode = explode('->', $value);
        if (sizeof($valueexplode) == 2) {
            $phone = $valueexplode[0];
            $message = $valueexplode[1];

            $datas[$i] = array(
                "phone" => $phone,
                "message" => $message
            );

            $i++;
        }
    }

    foreach ($datas as $row) {
        array_walk($row, 'cleanData');
        echo implode("\t", array_values($row)) . "\r\n";
    }
}

exit;
?>
