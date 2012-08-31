<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$sql = "SELECT Nombrecompleto ";
$sql = $sql . "FROM Usuario ";
$sql = $sql . "WHERE Nombreusuario = ?";

$statement = $dbh->prepare($sql);
$statement->execute(array($_GET['username']));
$result = $statement->fetchAll();

$response->success = 'OK';

if (count($result) > 0)
    $response->success = 'NOOK';

echo json_encode($response);
?>
