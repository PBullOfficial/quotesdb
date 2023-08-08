<?php 
    class Author {
        // DB Stuff
        private $conn;
        private $table = 'authors';

        // Author Properties
        public $id;
        public $author;

        // Constructor with DB
		public function __construct($db) {
			$this->conn = $db;
		}

        // Get authors
        public function read() {
        
        // Create query
        $query = 'SELECT id, author FROM ' . $this->table;
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Execute query
        $stmt->execute();
        return $stmt;
    }

        // Get single author
        public function read_single() {
            
            // Create query
            $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = ?';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Bind params
            $stmt->bindParam(1,$this->id);
            
            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->author = $row['author'];
        }

        // Create author
        public function create() {
            
            // Create query
            $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author)';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind params
            $stmt->bindParam(':author',$this->author);

            // Execute query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // Update author
            public function update() {
            
            // Create query
            $query = 'UPDATE ' . $this->table . ' SET author=:author WHERE id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind params
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':author',$this->author);

            // Execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // Delete author
            public function delete() {
            
            // Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind params
            $stmt->bindParam(':id',$this->id);

            // Execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

}