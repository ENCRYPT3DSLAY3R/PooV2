<?php

class Auth {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$localhost;dbname=$usuarios", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function authenticate($input_username, $input_password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute(array(':username' => $input_username, ':password' => $input_password));
        $user = $stmt->fetch();

        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: ./home.php');
        } else {
            echo "Invalid username or password.";
        }
    }
}

?>
