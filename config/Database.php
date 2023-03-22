<?php 
    class Database {
        // DB Params
        private $host = 'localhost';
        private $port = '5432';
        private $db_name = 'quotesdb';
        private $username = 'postgres';
        private $password = 'postgres';
        private $conn;

        // DB Connect
        public function connect() {
            $this->conn = null;
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

            try {
                $this->conn = new PDO($dsn, $this->username, $this->password);

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                // echo for tutorial, but log the error for production
                echo "Connection Error: " . $e->getMessage();
            }
            return $this->conn;
        }
    } 
    
?>