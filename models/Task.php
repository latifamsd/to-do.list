<?php
class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllTasksByUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT id, title, task, date, status FROM tasks WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
   
    
    public function addTask($title, $task, $date, $status, $user_id)
    {
    $stmt = $this->pdo->prepare("INSERT INTO tasks (title, task, date, user_id, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $task, $date, $user_id, $status]);
    }
    
    

    public function update($id, $title, $task, $date, $status) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET title = ?, task = ?, date = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $task, $date, $status, $id]);
    }
    

    public function deleteTask($id) {

        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getTaskById($id) {
        $stmt = $this->pdo->prepare("SELECT id, title, task, date ,status FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getTasksByStatus($user_id, $status) {
        $stmt = $this->pdo->prepare("SELECT id, title, task, date ,status FROM tasks WHERE user_id = ? AND status = ?");
        $stmt->execute([$user_id, $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    
}

?>
