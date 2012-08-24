<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$begdate = $_GET['firstdate'];
$enddate = $_GET['seconddate'];
$isdaily = $_GET['isdaily'];

$dbh = DBConnection::getInstance();

/**
 * Line report
 */
$linesql = "SELECT Fecha, MAX(Cantidadc) Claro, MAX(Cantidadm) Movistar ";
$linesql = $linesql . "FROM (SELECT Fecha, ";
$linesql = $linesql . "IFNULL((CASE WHEN Compania = 'claro' THEN Cantidad END), 0) Cantidadc, ";
$linesql = $linesql . "IFNULL((CASE WHEN Compania = 'movistar' THEN Cantidad END), 0) Cantidadm ";
$linesql = $linesql . "FROM (SELECT Compania, Fecha, COUNT(1) Cantidad ";
$linesql = $linesql . "FROM     (SELECT Compania, DATE_FORMAT(DATE(Fechaenvio), " . ($isdaily == "true" ? "'%d-%m-%Y'" : "'%m-%Y'") . ") Fecha ";
$linesql = $linesql . "FROM Enviomensaje ";
$linesql = $linesql . "WHERE DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') >= ? ";
$linesql = $linesql . "AND DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') <= ?) a ";
$linesql = $linesql . "GROUP BY Compania, Fecha) b) c ";
$linesql = $linesql . "GROUP BY Fecha ";
$linesql = $linesql . "ORDER BY 1";

$lineresult = $dbh->prepare($linesql);
$lineresult->execute(array($begdate, $enddate));
$linerows = $lineresult->fetchAll();

$linedata = array();
for ($i = 0; $i < count($linerows); $i++) {
    $row = $linerows[$i];
    $linedata[$i]->Fecha = $row[0];
    $linedata[$i]->Claro = intval($row[1]);
    $linedata[$i]->Movistar = intval($row[2]);
    $linedata[$i]->Total = intval($row[1]) + intval($row[2]);
}

/**
 * Pie report
 */
$piesql = "SELECT SUM(cantidadc) Claro, SUM(cantidadm) Movistar ";
$piesql = $piesql . "FROM (SELECT IFNULL((CASE WHEN Compania = 'claro' THEN Cantidad END), 0) Cantidadc, ";
$piesql = $piesql . "IFNULL((CASE WHEN Compania = 'movistar' THEN Cantidad END), 0) Cantidadm ";
$piesql = $piesql . "FROM (SELECT Compania, COUNT(1) Cantidad ";
$piesql = $piesql . "FROM (SELECT compania FROM Enviomensaje ";
$piesql = $piesql . "WHERE DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') >= ? ";
$piesql = $piesql . "AND DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') <= ?) a ";
$piesql = $piesql . "GROUP BY Compania) b) c";

$pieresult = $dbh->prepare($piesql);
$pieresult->execute(array($begdate, $enddate));
$pierows = $pieresult->fetchAll();

$piedata = array();
$piedata[0]->name = 'Claro';
$piedata[0]->value = intval($pierows[0][0]);
$piedata[1]->name = 'Movistar';
$piedata[1]->value = intval($pierows[0][1]);

/**
 * Bar report
 */
$barsql = "SELECT Usuario, Nombrecompleto, SUM(Cantidadc) Claro, SUM(Cantidadm) Movistar ";
$barsql = $barsql . "FROM (SELECT Usuario, Nombrecompleto, ";
$barsql = $barsql . "IFNULL((CASE WHEN Compania = 'claro' THEN Cantidad END), 0) Cantidadc, ";
$barsql = $barsql . "IFNULL((CASE WHEN Compania = 'movistar' THEN Cantidad END), 0) Cantidadm ";
$barsql = $barsql . "FROM (SELECT Usuario, Nombrecompleto, Compania, COUNT(1) Cantidad ";
$barsql = $barsql . "FROM Enviomensaje e, Usuario u ";
$barsql = $barsql . "WHERE e.Usuario = u.Nombreusuario ";
$barsql = $barsql . "AND DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') >= ? ";
$barsql = $barsql . "AND DATE_FORMAT(DATE(Fechaenvio), '%d/%m/%Y') <= ? ";
$barsql = $barsql . "GROUP BY Usuario, NombreCompleto, Compania) a) b ";
$barsql = $barsql . "GROUP BY Usuario, Nombrecompleto";

$barresult = $dbh->prepare($barsql);
$barresult->execute(array($begdate, $enddate));
$barrows = $barresult->fetchAll();

$bardata = array();
for ($i = 0; $i < count($barrows); $i++) {
    $row = $barrows[$i];
    $bardata[$i]->Usuario = $row[0];
    $bardata[$i]->Nombre = $row[1];
    $bardata[$i]->Claro = intval($row[2]);
    $bardata[$i]->Movistar = intval($row[3]);
    $bardata[$i]->Total = intval($row[2]) + intval($row[3]);
}

$response->success = true;
$response->linedata = $linedata;
$response->piedata = $piedata;
$response->bardata = $bardata;

echo json_encode($response);
?>
