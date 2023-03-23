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
            if(isset($_GET['id'])) {
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
                WHERE
                    quotes.id = :id
                LIMIT 1';
            }
            // Prepate statement
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (is_array($row)) {
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->category = $row['category'];
            }
        
        if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
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
            WHERE
                quotes.author_id = :author_id
            AND
                quotes.category_id = :category_id
            ORDER BY quotes.id';
        
            $this->author_id = $_GET['author_id'];
            $this->category_id = $_GET['category_id'];
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->execute();
        
            $quotes = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                $quotes[] = [
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category
                ];
            }
            
            return $quotes;
        }
        
        if (isset($_GET['author_id'])) {
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
            WHERE
                quotes.author_id = :id
            ORDER BY quotes.id';
            // Prepate statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        
            $quotes = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                $quotes[] = [
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category
                ];
            }
            
            return $quotes;
        }
        
        if (isset($_GET['category_id'])) {
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
            WHERE
                quotes.category_id = :id
            ORDER BY quotes.id';
            // Prepate statement
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        
            $quotes = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
            
                $quotes[] = [
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category
                ];
            }
            
            return $quotes;
        }
    }

        // Create Quote
        public function create() {
            // Create query
            $query = 'INSERT INTO ' . 
                    $this->table . '(quote, author_id, category_id)
            VALUES(
                    :quote, :author_id, :category_id)';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

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
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                WHERE
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

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
            $query = 'DELETE FROM ' 
                . $this->table . 
            'WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);
           
            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;

        }
    }