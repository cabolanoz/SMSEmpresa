<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$begdate = $_GET['firstdate'];
$enddate = $_GET['seconddate'];
$isdaily = $_GET['isdaily'];

$sql = "SELECT   compania, fecha, COUNT(1) cantidad ";
$sql = $sql . "FROM     (SELECT compania, DATE_FORMAT(DATE(fechaenvio), " . ($isdaily ? "'%d-%m-%Y'" : "'%m-%Y'") . ") fecha ";
$sql = $sql . "FROM   enviomensaje ";
$sql = $sql . "WHERE  DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') >= ? AND DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') <= ?) a ";
$sql = $sql . "GROUP BY compania, fecha";

$dbh = DBConnection::getInstance();

$result = $dbh->prepare($sql);
$result->execute(array($begdate, $enddate));
$rows = $result->fetchAll();

$datas = array();
for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    $datas[$i]->company = $row[0];
    $datas[$i]->date = $row[1];
    $datas[$i]->quantity = $row[2];
}

$response->success = true;
$response->datas = $datas;

echo json_encode($response);
?>
