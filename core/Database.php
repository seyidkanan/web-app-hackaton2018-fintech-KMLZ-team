<?php

class Database{
    private static $db;
    private function __construct() {
        try {
            static::$db = new PDO("mysql:host=".HOST.";dbname=".DATABASE,  USERNAME, PASS);
            //static::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            static::$db->exec("set names utf8");
        }
            catch(PDOException $e) {
            echo $e->getMessage();
        }
        
    }
    
    public static function getDB(){
         if(static::$db!=null){
             return static::$db;
             
         }else{
             new Database();
             return static::$db;
         }
            
       
    }
}