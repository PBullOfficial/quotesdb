<?php 
    class Author {
        // DB Stuff
        private $conn;
        private $table = 'authors';

        // Properties
        public $id;
        public $author;

        // Constructor with DB
		public function __construct($db) {
			$this->conn = $db;
		}

        // Get categories
        public function read_all() {
            // Create query
            $query = 'SELECT 
                id,
                author
            FROM
                ' . $this->table . '
            ORDER BY
                id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }
