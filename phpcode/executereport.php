<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$begdate = $_GET['firstdate'];
$enddate = $_GET['seconddate'];
$isdaily = $_GET['isdaily'];

Logger::info($begdate);
Logger::info($enddate);
Logger::info($isdaily);

$sql = "SELECT Fecha, MAX(cantidadc) Claro, MAX(cantidadm) Movistar ";
$sql = $sql . "FROM (SELECT Fecha, ";
$sql = $sql . "IFNULL((CASE WHEN Compania = 'claro' THEN Cantidad END), 0) Cantidadc, ";
$sql = $sql . "IFNULL((CASE WHEN Compania = 'movistar' THEN Cantidad END), 0) Cantidadm ";
$sql = $sql . "FROM (SELECT Compania, Fecha, COUNT(1) Cantidad ";
$sql = $sql . "FROM     (SELECT compania, DATE_FORMAT(DATE(fechaenvio), " . ($isdaily ? "'%d-%m-%Y'" : "'%m-%Y'") . ") Fecha ";
$sql = $sql . "FROM Enviomensaje ";
$sql = $sql . "WHERE DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') >= ? ";
$sql = $sql . "AND DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') <= ?) a ";
$sql = $sql . "GROUP BY Compania, Fecha) b) c ";
$sql = $sql . "GROUP BY Fecha ";
$sql = $sql . "ORDER BY 1";

Logger::info($sql);

$dbh = DBConnection::getInstance();

$result = $dbh->prepare($sql);
$result->execute(array($begdate, $enddate));
$rows = $result->fetchAll();

$datas = array();
for ($i = 0; $i < count($rows); $i++) {
    $row = $rows[$i];
    $datas[$i]->Fecha = $row[0];
    $datas[$i]->Claro = $row[1];
    $datas[$i]->Movistar = $row[2];
}

$response->success = true;
$response->datas = $datas;

echo json_encode($response);
?>
