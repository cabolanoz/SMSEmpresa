<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$sql = "Select m.Nombre, pm.Acceso ";
$sql = $sql . "From   Perfil_Menu pm, Perfil p, Menu m ";
$sql = $sql . "Where  pm.Idperfil = p.Idperfil And pm.Idmenu = m.Idmenu And p.Nombre = ?";

$statement = $dbh->prepare($sql);
$statement->execute(array($_GET['profile']));

$result = $statement->fetchAll();

$counter = 0;

$datas = array();

foreach ($result as $row) {
    $menuname = $row[0];
    $menuaccess = $row[1];
    
    $datas[$counter]->name = $menuname;
    $datas[$counter]->access = intval($menuaccess) == 1 ? true : false;
    
    $counter++;
}

$response->success = true;
$response->datas = $datas;

echo json_encode($response);
?>
