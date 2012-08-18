<?php

/**
 * @author: César Bolaños [cbolanos]
 */

session_start();
session_destroy();

header('Location: ../index.php');
exit();
?>
