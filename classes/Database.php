<?php
    class Database {
        #define properties
        private $server_name = "localhost";     //
        private $username    = "root";          // this is by default
        private $password    = "root";          //this is default for MAMP
        private $db_name     = "the_company";   // name of the php my admin database
        protected $conn;

        #define the constructor : this is how to access to the properties
        public function __construct(){
            $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name); 
            //mysqli() is a built-in class file in PHP / in mysqli() is also have properties(variables) snd methods(functions) that we can call in order to use it

            # Check if there is no error in connecting to the database
            if($this->conn->connect_error) { //Boolean: true or false
                die("Unable to connect to the database." . $this->conn->connect_error);
            }
        }
    }
?>