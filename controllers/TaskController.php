<?php
require_once 'models/Task.php';

class TaskController {
    private $pdo;
    private $taskModel;

    public function __construct($pdo) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Démarre la session uniquement si aucune session n'est active
        }
        $this->pdo = $pdo;
        $this->taskModel = new Task($pdo);
    }
    

    private function ensureLoggedIn() {
        if (!isset($_SESSION['id'])) {
            header('Location: /login'); // Redirige vers la page de connexion
            exit;
        }
    }

    public function index() {
        $this->ensureLoggedIn();
        $user_id = $_SESSION['id'];
        $tasks = $this->taskModel->getAllTasksByUser($user_id);
        require 'views/index.php';
    }
    
    public function add() {
        $this->ensureLoggedIn();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $task = $_POST['task'];
            $date = $_POST['date'];
            $status = $_POST['status'];
            $user_id = $_SESSION['id'];
    
            // 🔍 Vérifier si l'utilisateur existe bien dans la base de données
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
    
            if (!$user) {
                die("Erreur : L'utilisateur associé à cette tâche n'existe pas.");
            }
    
            // Ajouter la tâche si l'utilisateur existe
            $this->taskModel->addTask($title, $task, $date, $status, $user_id);
            header('Location: /');
            exit;
        } else {
            require 'views/add.php';
        }
    }
    

    public function edit($id) {
        $this->ensureLoggedIn(); // Vérifie si l'utilisateur est connecté

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $task = $_POST['task'];
            $date = $_POST['date'];
            $status = $_POST['status'];

            $this->taskModel->update($id, $title, $task, $date,$status);
            header('Location: /');
            exit;
        } else {
            $task = $this->taskModel->getTaskById($id);
            if (!$task) {
                echo "Tâche introuvable.";
                return;
            }
            require 'views/edit.php';
        }
    }

    public function delete($id) {
        $this->ensureLoggedIn(); // Vérifie si l'utilisateur est connecté

        $this->taskModel->deleteTask($id);
        header('Location: /');
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare("INSERT INTO users (name,email, password) VALUES (?,?, ?)");
            $stmt->execute([$name,$email, $password]);
            header('Location: /login');
            exit;
        } else {
            require 'views/signup.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                header('Location: /');
                exit;
            } else {
                $error = "Email ou mot de passe invalide.";
            }
        }

        require 'views/login.php';
    }

    public function logout() {
        session_unset(); // Clear session data
        session_destroy(); // Destroy the session
        header('Location: /login');
        exit;
    }
    
    
    
}

?>
