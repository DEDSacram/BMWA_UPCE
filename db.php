<?php
include 'config.php';
class Database {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function close() {
        $this->conn = null;
    }


    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }



    // $username = 'example_username';
    // $stmt = $db->query("SELECT * FROM users WHERE username = :username", [':username' => $username]);
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);


    // public function createUser($email, $password) {
    //     try {
    //         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //         $stmt = $this->conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    //         $stmt->bindParam(':email', $email);
    //         $stmt->bindParam(':password', $hashedPassword);
    //         $stmt->execute();
    //         echo "User created successfully";
    //     } catch(PDOException $e) {
    //         echo "Error creating user: " . $e->getMessage();
    //     }
    // }
    
}

// Usage example:
$db = new Database("127.0.0.1", 3306, "admin", "admin12345", "bmwa");
$db->connect();

// Perform your database operations here

$db->close();
