<?php

/**
 * @author: César Bolaños [cbolanos]
 */
class DBConnection {
    
    public static $instance;
   
 
    public static function getInstance($hostname='localhost',$databasename='smsempresa',$username='root',$password=''){
        if(!isset(self::$instance))
            self::$instance=new PDO('mysql:host=localhost;dbname=smsempresa', 'root', '');
        
        return self::$instance;
    }
    
}

?>
