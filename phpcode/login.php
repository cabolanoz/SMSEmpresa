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
    $sql = "SELECT Idperfil, Nombrecompleto FROM Usuario WHERE Nombreusuario='" . $user . "' AND Contrasenia=MD5('" . $password . "') AND Activo=1 AND Conectado=0";

    $dbh = DBConnection::getInstance();

    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    
    if (count($result) == 0)
        return false;
    else {
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
        $_SESSION['profile'] = $result[0][0];
        $_SESSION['username'] = $result[0][1];
        
        try {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
        
            $newsql = "Update Usuario Set Conectado = b'1' Where Nombreusuario = '" . $user . "'";
            $dbh->exec($newsql);
            $dbh->commit();
        } catch (Exception $e) {
            
        }
        
        return true;
    }
}

?>