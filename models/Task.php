<?php
require_once __DIR__ . '/../config.php';

class Task {

    // Adds a new task to the database
    public static function add($userId, $categoryId, $title, $description, $priority, $dueDate) {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            INSERT INTO tasks (user_id, category_id, title, description, priority, due_date)
            VALUES (:user_id, :category_id, :title, :description, :priority, :due_date)
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':category_id' => $categoryId ?: null, // Set to null if not provided
            ':title' => $title,
            ':description' => $description ?: null,
            ':priority' => $priority,
            ':due_date' => $dueDate ?: null
        ]);
    }

    // Retrieves all tasks for a specific user, including the category name
    public static function getAll($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT tasks.*, categories.name AS category_name
            FROM tasks
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.user_id = ?
            ORDER BY tasks.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Retrieves a single task by its ID and user ID
    public static function getById($id, $userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    // Updates an existing task
    public static function update($id, $userId, $categoryId, $title, $description, $priority, $dueDate, $status) {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            UPDATE tasks SET category_id = :category_id, title = :title, description = :description,
            priority = :priority, due_date = :due_date, status = :status
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':category_id' => $categoryId ?: null,
            ':title' => $title,
            ':description' => $description ?: null,
            ':priority' => $priority,
            ':due_date' => $dueDate ?: null,
            ':status' => $status,
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    // Sets the status of a task (e.g., to "done") and optionally sets the completed time
    public static function setStatus($id, $userId, $status) {
        $pdo = getPDO();
        $completed_at = $status === 'done' ? date('Y-m-d H:i:s') : null;

        $stmt = $pdo->prepare("
            UPDATE tasks SET status = :status, completed_at = :completed_at
            WHERE id = :id AND user_id = :user_id
        ");
        $stmt->execute([
            ':status' => $status,
            ':completed_at' => $completed_at,
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    // Searches for tasks based on keyword, category, priority, and status
    public static function search($userId, $term, $categoryId, $priority, $status) {
        $pdo = getPDO();
        $sql = "
            SELECT tasks.*, categories.name AS category_name
            FROM tasks
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.user_id = :user_id
            AND (title LIKE :term OR description LIKE :term)
        ";

        $params = [
            ':user_id' => $userId,
            ':term' => '%' . $term . '%'
        ];
    
        // Add category filter if provided
        if ($categoryId) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }
    
        // Add priority filter if provided
        if ($priority) {
            $sql .= " AND priority = :priority";
            $params[':priority'] = $priority;
        }
    
        // Add status filter if provided
        if ($status) {
            $sql .= " AND status = :status";
            $params[':status'] = $status;
        }
    
        $sql .= " ORDER BY created_at DESC";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Returns a count of tasks grouped by their status (e.g., "pending", "done")
    public static function getStatusCounts($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT status, COUNT(*) AS count
            FROM tasks
            WHERE user_id = ?
            GROUP BY status
        ");
        $stmt->execute([$userId]);
    
        $result = [];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['status']] = $row['count'];
        }
    
        return $result;
    }

    // Returns the number of overdue tasks
    public static function getOverdueCount($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM tasks
            WHERE user_id = ? AND due_date IS NOT NULL AND due_date < NOW() AND status != 'done'
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    // Returns a summary of tasks per category, including how many are done
    public static function getCategorySummary($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT c.name AS category, COUNT(t.id) AS total,
                   SUM(CASE WHEN t.status = 'done' THEN 1 ELSE 0 END) AS done
            FROM categories c
            LEFT JOIN tasks t ON c.id = t.category_id
            WHERE c.user_id = ?
            GROUP BY c.id
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // Deletes a task by ID and user ID
    public static function delete($id, $userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    // Retrieves all tasks of a user filtered by a specific category
    public static function getByCategory($userId, $categoryId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT tasks.*, categories.name AS category_name
            FROM tasks
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.user_id = ? AND tasks.category_id = ?
            ORDER BY tasks.created_at DESC
        ");
        $stmt->execute([$userId, $categoryId]);
        return $stmt->fetchAll();
    }
}

?>