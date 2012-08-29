<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$sql = "SELECT Compania, Prefijo ";
$sql = $sql . "FROM Prefijo ";
$sql = $sql . "ORDER BY 1, 2";

$result = $dbh->prepare($sql);
$result->execute();
$rows = $result->fetchAll();

$clarocounter = 0;
$movistarcounter = 0;

$clarodata = array();
$movistardata = array();

for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    if ($row[0] == 'claro') {
        $clarodata[$clarocounter]->value = $row[1];
        $clarocounter++;
    } else {
        $movistardata[$movistarcounter]->value = $row[1];
        $movistarcounter++;
    }
}

$response->success = true;
$response->claro = $clarodata;
$response->movistar = $movistardata;

echo json_encode($response);
?>
