<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$begdate = $_GET['firstdate'];
$enddate = $_GET['seconddate'];

// Daily
//SELECT   compania, fecha, COUNT(1) cantidad
//FROM     (SELECT compania, DATE_FORMAT(DATE(fechaenvio), '%d-%m-%Y') fecha
//          FROM   enviomensaje
//          WHERE  DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') >= '01/08/2012' AND DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') <= '17/08/2012') a
//GROUP BY compania, fecha

// Monthly
//SELECT   compania, fecha, COUNT(1) cantidad
//FROM     (SELECT compania, DATE_FORMAT(DATE(fechaenvio), '%m-%Y') fecha
//          FROM   enviomensaje
//          WHERE  DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') >= '01/08/2012' AND DATE_FORMAT(DATE(fechaenvio), '%d/%m/%Y') <= '17/08/2012') a
//GROUP BY compania, fecha

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
