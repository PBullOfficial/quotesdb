<?php 
    require_once('../categories/index.php');
    require_once('../categories/read.php');
    require_once('../../config/Database.php');

    class Category {
        // DB Stuff
        private $conn;
        private $table = 'categories';

        // Properties
        public $id;
        public $category;

        // Constructor with DB
        public function __contruct($db) {
            $this->conn = $db;
        }

        // Get categories
        public function read() {
            // Create query
            $query = 'SELECT 
                id,
                category
            FROM
                ' . $this->table . '
            ORDER BY
                id DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }

?>