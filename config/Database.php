<?php 
    class Database {
        // DB Params
        private $conn;
        private $url;
        private $dbparts;
        private $hostname;
        private $username;
        private $password;
        private $database;



        function __construct(){
            $this->conn = null;
            $this->url = getenv('JAWSDB_URL');
            $this->dbparts = parse_url($this->url);
        }

        // DB Connect
        public function connect() {

            $dbparts = parse_url($url);

            $hostname = $this->dbparts['host'];
            $username = $this->dbparts['user'];
            $password = $this->dbparts['pass'];
            $database = ltrim($this->dbparts['path'],'/');

            try {
                $this->conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Success!";
            } catch(PDOException $e) {
                echo "Connection Error: " . $e->getMessage();
            }

            return $this->conn;
        }
    } 

?>