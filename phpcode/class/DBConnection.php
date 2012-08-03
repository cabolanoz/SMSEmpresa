<?php

/**
 * @author: César Bolaños [cbolanos]
 */
class DBConnection {
    
    public static $connection = null;
    
    private $defaulthostname = "localhost";
    private $defaultusername = "root";
    private $defaultpassword = "";
    private $defaultdatabase = "smsempresa";
    
    private $hostname;
    private $username;
    private $password;
    
    function __construct($_hostname, $_username, $_password) {
        $this->hostname = !isset($_hostname) ? $this->defaulthostname : $_hostname;
        $this->username = !isset($_username) ? $this->defaultusername : $_username;
        $this->password = !isset($_password) ? $this->defaultpassword : $_password;
    }
    
    function getConnection() {
        if (!isset($this->connection)) {
            $this->connection = mysql_connect($this->hostname, $this->username, $this->password);
            mysql_select_db($this->defaultdatabase, $this->connection);
        }
        
        return $this->connection;
    }
}

?>
