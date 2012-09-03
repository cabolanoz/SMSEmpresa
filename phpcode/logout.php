<?php

/**
 * @author: César Bolaños [cbolanos]
 */

session_start();

require_once 'class/DBConnection.php';

$dbh = DBConnection::getInstance();

try {
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->beginTransaction();
    
    $newsql = "Update Usuario Set Conectado = b'0' Where Nombreusuario = '" . $_SESSION['user'] . "'";
    $dbh->exec($newsql);
    $dbh->commit();
} catch (Exception $e) {
    
}

session_destroy();

header('Location: ../index.php');
exit();
?>
