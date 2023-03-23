<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Quote Properties
        public $id;
        public $quote;
        public $author;
        public $author_id;
        public $category;
        public $category_id;

        // Constructor with DB
		public function __construct($db) {
			$this->conn = $db;
		}

        // Get quotes
        public function read_all() {
            // Create query
            $query = 'SELECT 
                quotes.id,
                quotes.quote,
                authors.author,
                categories.category
            FROM
                ' . $this->table . ' 
            INNER JOIN
                authors
            ON
                quotes.author_id = authors.id
            INNER JOIN
                categories
            ON
                quotes.category_id = categories.id
            ORDER BY
                id DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get Single Quote
        public function read_single() {
                // Create query
            $query = 'SELECT 
                c.category as category_name,
                p.id,
                p.categoryId,
                p.quote
            FROM
                ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.categoryId = c.id
            WHERE 
                p.id = ?
            LIMIT 0,1';

            // Prepate statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Set properties
            $this->category = $row['category'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->categoryId = $row['categoryId'];
            $this->authorId = $row['authorId'];
        }

        // Create Quote
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    categoryId = :categoryId';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->authore));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this-body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':categoryId', $this->categoryId);

            if ($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }    
    
        // Update Quote
        public function update() {
            // Create query
            $query = 'UPDATE ' . 
                    $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    categoryId = :categoryId
                WHERE
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->authore));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));        
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this-body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':categoryId', $this->categoryId);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;
        }

        // Delete Quote
        public function delete() {
            // Create query
            $query = 'DELETE FROM ' . $this->table . 'WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);


        }
    }