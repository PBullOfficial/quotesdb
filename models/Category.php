<?php 
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Category Properties
    public $id;
    public $category;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get categories
    public function read() {
        
        // Create query
        $query = 'SELECT id, category FROM ' . $this->table;
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Execute query
        $stmt->execute();
        return $stmt;
    }

        // Get single category
        public function read_single() {
            
            // Create query
            $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = ?';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Bind params
            $stmt->bindParam(1,$this->id);
            
            // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->category = $row['category'];
        }

        // Create category
        public function create() {
            
            // Create query
            $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';
            
            // Orepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind params
            $stmt->bindParam(':category',$this->category);

            // Execute query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // Update CATEGORY
            public function update() {
            
            // Create query
            $query = 'UPDATE ' . $this->table . ' SET category=:category WHERE id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind params
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':category',$this->category);

            // Execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // Delete Category
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