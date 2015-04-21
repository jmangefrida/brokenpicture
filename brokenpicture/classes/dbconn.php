<?php

//namespace classes;

// The Database class represents our global DB connection
class dbconn extends PDO
{
        // A static variable to hold our single instance
        private static $_instance = null;

        // Make the constructor private to ensure singleton
        function __construct()
        {
                // Call the PDO constructor
                parent::__construct('mysql:host=localhost;dbname=drawing', 'draw', 'aurelia');
        }

        // A method to get our singleton instance
        public static function getInstance()
        {
                if (!(self::$_instance instanceof dbconn)) {
                        self::$_instance = new dbconn();
                }

                return self::$_instance;
        }
         
        
}

?>