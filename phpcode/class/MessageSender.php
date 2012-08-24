<?php

/**
 * @author: César Bolaños [cbolanos]
 */
session_start();
require_once 'DBConnection.php';
require_once dirname(__FILE__) . '/../util/Logger.php';

class MessageSender {

    public function insertMessages($datas, $company) {

        Logger::info('Entering insert messages');

        $dbh = DBConnection::getInstance();

        Logger::info('Connection object');

        try {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();

            foreach ($datas as $data) {
                $sql = "INSERT INTO Enviomensaje (Numerotelefono, Mensaje, Fechaenvio, Compania, Usuario) VALUES ('" .
                        '505' . $data->phone . "', '" .
                        $data->message . "', '" .
                        date('c') . "', '" .
                        $company . "', '"
                        $_SESSION['user'] . "');";

                $dbh->exec($sql);
            }

            $dbh->commit();
        } catch (Exception $e) {
            $dbh->rollBack();
            return false;
        }

        return true;
    }

}

?>