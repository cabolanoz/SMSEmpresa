<?php

/**
 * @author: César Bolaños [cbolanos]
 */

require_once 'class/DBConnection.php';
require_once dirname(__FILE__) . '/util/Logger.php';

$dbh = DBConnection::getInstance();

$menusql = "Select   Idmenu, Nombre ";
$menusql = $menusql . "From     Menu ";
$menusql = $menusql . "Order By 1";

$menuresult = $dbh->prepare($menusql);
$menuresult->execute();
$menurows = $menuresult->fetchAll();

$menu = "";
foreach ($menurows as $row) {
    $idmenu = $row[0];
    $hasaccess = false;

    $sql = "Select Count(1) ";
    $sql = $sql . "From   Perfil_Menu ";
    $sql = $sql . "Where  Idperfil = " . $_SESSION['profile'] . " And Idmenu = " . $idmenu . " And Acceso = 1";

    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    
    if (count($result) > 0 && intval($result[0][0]) > 0)
        $hasaccess = true;

    Logger::info("profile " . $_SESSION['profile']);
    Logger::info("idmenu " . $idmenu);
    Logger::info("hasaccess " . $hasaccess);
    
    switch ($idmenu) {
        case 1:
            if ($hasaccess)
                $menu = $menu . "<li><a href='javascript:onClick = updateBodyPanel(0)'>" . $row[1] . "</a></li>";
            break;
        case 2:
            if ($hasaccess) {
                $menu = $menu . "<li><a href='#'>" . $row[1] . "</a>";
                $menu = $menu . "<ul>";
                $menu = $menu . "<li><a href='javascript:onClick=updateBodyPanel(1)'>Claro</a></li>";
                $menu = $menu . "<li><a href='javascript:onClick=updateBodyPanel(2)'>Movistar</a></li>";
                $menu = $menu . "<li><a href='javascript:onClick=updateBodyPanel(3)'>Personalizado</a></li>";
                $menu = $menu . "</ul>";
                $menu = $menu . "</li>";
            }
            break;
        case 3:
            if ($hasaccess)
                $menu = $menu . "<li><a href='javascript:onClic=showPrefixFloatableWindow()'>" . $row[1] . "</a></li>";
            break;
        case 4:
            if ($hasaccess)
                $menu = $menu . "<li><a href='javascript:onClick=showReportFloatableWindow()'>" . $row[1] . "</a></li>";
            break;
        case 5:
            if ($hasaccess)
                $menu = $menu . "<li><a href='javascript:onClick=updateBodyPanel(5)'>" . $row[1] . "</a></li>";
            break;
    }
}

echo $menu;
?>
