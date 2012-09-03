<?php

/**
 * @author: César Bolaños [cbolanos]
 */
require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$profilesql = "SELECT Idperfil, Nombre, Descripcion ";
$profilesql = $profilesql . "FROM Perfil ";
$profilesql = $profilesql . "ORDER BY Idperfil";

$profilestatement = $dbh->prepare($profilesql);
$profilestatement->execute();
$profileresult = $profilestatement->fetchAll();

$j = 0;

$profiles = array();

foreach ($profileresult as $row) {
    $profileid = $row[0];
    $profilename = $row[1];
    $profiledescription = $row[2];
    
    $profiles[$j]->id = $profileid;
    $profiles[$j]->name = $profilename;
    $profiles[$j]->description = $profiledescription;
    
    $j++;
}

$usersql = "SELECT Idperfil, Nombreusuario, Nombrecompleto ";
$usersql = $usersql . "FROM Usuario ";
$usersql = $usersql . "WHERE Activo = 1 ";
$usersql = $usersql . "ORDER BY Idusuario";

$userstatement = $dbh->prepare($usersql);
$userstatement->execute();
$userresult = $userstatement->fetchAll();

$counter = 0;

$items = array();

foreach ($userresult as $userrow) {
    $profileid = intval($userrow[0]);
    $username = $userrow[1];
    $name = $userrow[2];
    
    $items[$counter]->text = $username;
    $items[$counter]->cls = 'folder';
    $items[$counter]->expanded = false;
    $items[$counter]->qtip = $username;
    
    $i = 0;
    
    $children = array();
    foreach ($profileresult as $profilerow) {
        $id = intval($profilerow[0]);
        $profile = $profilerow[1];
        $description = $profilerow[2];
        
        $children[$i]->text = $profile;
        $children[$i]->leaf = true;
        $children[$i]->qtip = $description;
        if ($profileid == $id)
            $children[$i]->checked = true;
        else
            $children[$i]->checked = false;
        
        $i++;
    }
    
    if (count($children) > 0)
        $items[$counter]->children = $children;
    
    $counter++;
}

$response->success = true;
$response->profiles = $profiles;
$response->items = $items;

echo json_encode($response);

?>
