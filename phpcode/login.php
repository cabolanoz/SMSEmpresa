<?php

/**
 * @author: César Bolaños [cbolanos]
 */
session_start();

require_once 'class/DBConnection.php';

$user = $_GET['user'];
$password = $_GET['password'];

if (userExist($user, $password)) {
    echo json_encode(true);
} else
    echo json_encode(false);

function userExist($user, $password) {
    $sql = "SELECT Nombrecompleto FROM Usuario WHERE Nombreusuario='" . $user . "' AND Contrasenia=MD5('" . $password . "') AND Activo=1 AND Conectado=0";

    $dbh = DBConnection::getInstance();

    $result = $dbh->query($sql);
    if ($result->rowCount() == 0)
        return false;
    else {
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
        $_SESSION['username'] = $result->fetchColumn(0);
        $result->closeCursor();
        return true;
    }
}

?>