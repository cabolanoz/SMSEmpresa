<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$begdate = $_GET['firstdate'];
$enddate = $_GET['seconddate'];

$sql = "SELECT idenvio, fechaenvio, compania ";
$sql = $sql . "FROM   (SELECT idenvio, DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') fechaenvio, compania FROM enviomensaje) a ";
$sql = $sql . "WHERE  fechaenvio >= ? AND fechaenvio <= ?";

$dbh = DBConnection::getInstance();

$result = $dbh->prepare($sql);
$result->execute(array($begdate, $enddate));
$rows = $result->fetchAll();

$datas = array();
for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    $datas[$i]->sentdate = $row[1];
    $datas[$i]->company = $row[2];
}

$response->success = true;
$response->datas = $datas;

echo json_encode($response);
?>
