<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$sql = "INSERT INTO Usuario
      (
          Idperfil,
          Nombreusuario,
          Contrasenia,
          Nombrecompleto,
          Activo,
          Conectado
      )
VALUES (?, ?, ?, ?, ?, ?)";

$statement = $dbh->prepare($sql);
$statement->execute(array($_GET['username'], $_GET['name'], $_GET['password']));

?>
