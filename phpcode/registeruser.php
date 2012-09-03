<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$response->success = 'NOOK';

try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->beginTransaction();
    
    $sql = "INSERT INTO Usuario (Idperfil, Nombreusuario, Contrasenia, Nombrecompleto, Activo, Conectado) VALUES (";
    $sql = $sql . "'" . $_GET['profile'] . "', ";
    $sql = $sql . "'" . $_GET['username'] . "', ";
    $sql = $sql . "MD5('" . $_GET['password'] . "'), ";
    $sql = $sql . "'" . $_GET['name'] . "', ";
    $sql = $sql . "1, ";
    $sql = $sql . "0)";

    $statement = $dbh->prepare($sql);
    $statement->execute();
    
    $dbh->commit();
    
    $response->success = 'OK';
} catch (Exception $e) {
    $dbh->rollBack();
}

echo json_encode($response);

?>
