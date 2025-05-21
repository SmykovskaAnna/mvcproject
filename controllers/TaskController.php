<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Category.php';

class TaskController {
    public static function list() {
        self::checkLogin();

        $userId = $_SESSION['user_id'];
        $categoryId = $_GET['category_id'] ?? null;

        // If a category is selected, fetch tasks for that category; otherwise, fetch all tasks
        if ($categoryId) {
            $tasks = Task::getByCategory($userId, $categoryId);
        } else {
            $tasks = Task::getAll($userId);
        }

        $categories = Category::getAll($userId);
        $statusCounts = Task::getStatusCounts($userId);

        // Calculate percentages for each task status
        $total = array_sum($statusCounts);
        $donePercent = $total > 0 ? round(($statusCounts['done'] ?? 0) / $total * 100) : 0;
        $inProgressPercent = $total > 0 ? round(($statusCounts['in_progress'] ?? 0) / $total * 100) : 0;
        $todoPercent = $total > 0 ? round(($statusCounts['todo'] ?? 0) / $total * 100) : 0;

        include __DIR__ . '/../views/task_list.php';
    }

    public static function add() {
        self::checkLogin();
        $error = "";
        $categories = Category::getAll($_SESSION['user_id']);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description'] ?? '');
            $categoryId = $_POST['category_id'] ?? null;
            $priority = $_POST['priority'] ?? 'medium';
            $dueDate = $_POST['due_date'] ?? null;
    
            // Input validation
            if (strlen($title) < 3 || strlen($title) > 100) {
                $error = "The task name must contain between 3 and 100 characters.";
            } elseif ($description && strlen($description) > 1000) {
                $error = "The description cannot exceed 1000 characters.";
            } elseif (!in_array($priority, ['low', 'medium', 'high'])) {
                $error = "Wrong priority.";
            } elseif ($dueDate && !DateTime::createFromFormat('Y-m-d\TH:i', $dueDate)) {
                // HTML datetime-local format: "Y-m-d\TH:i"
                $error = "Invalid date format.";
            } else {
                // Convert to MySQL datetime format
                $dueDate = $dueDate ? date('Y-m-d H:i:s', strtotime($dueDate)) : null;
                Task::add($_SESSION['user_id'], $categoryId, $title, $description, $priority, $dueDate);
                header('Location: index.php?action=tasks');
                exit;
            }
        }
    
        include __DIR__ . '/../views/add_task.php';
    }
    
    private static function checkLogin() {
        // Redirect user to login page if not authenticated
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public static function edit() {
        self::checkLogin();
        $error = "";
        $id = $_GET['id'] ?? null;
        $task = Task::getById($id, $_SESSION['user_id']);
        $categories = Category::getAll($_SESSION['user_id']);
    
        if (!$task) {
            echo "The task was not found or is unavailable.";
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description'] ?? '');
            $categoryId = $_POST['category_id'] ?? null;
            $priority = $_POST['priority'] ?? 'medium';
            $dueDate = $_POST['due_date'] ?? null;
            $status = $_POST['status'] ?? 'todo';
    
            // Input validation
            if (strlen($title) < 3 || strlen($title) > 100) {
                $error = "The task name must contain between 3 and 100 characters.";
            } elseif ($description && strlen($description) > 1000) {
                $error = "The description cannot exceed 1000 characters.";
            } elseif (!in_array($priority, ['low', 'medium', 'high'])) {
                $error = "Wrong priority.";
            } elseif (!in_array($status, ['todo', 'in_progress', 'done'])) {
                $error = "Incorrect status.";
            } elseif ($dueDate && !DateTime::createFromFormat('Y-m-d\TH:i', $dueDate)) {
                $error = "Invalid date format.";
            } else {
                // Convert HTML date format to MySQL format
                $dueDate = $dueDate ? date('Y-m-d H:i:s', strtotime($dueDate)) : null;
                Task::update($id, $_SESSION['user_id'], $categoryId, $title, $description, $priority, $dueDate, $status);
                header('Location: index.php?action=tasks');
                exit;
            }
        }
    
        include __DIR__ . '/../views/edit_task.php';
    }    

    public static function setStatus() {
        self::checkLogin();
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;

        // Validate status
        if (!in_array($status, ['todo', 'in_progress', 'done'])) {
            echo "Incorrect status.";
            return;
        }

        Task::setStatus($id, $_SESSION['user_id'], $status);
        header('Location: index.php?action=tasks');
        exit;
    }

    public static function search() {
        self::checkLogin();
        $categories = Category::getAll($_SESSION['user_id']);
        $results = [];
        $term = $categoryId = $priority = $status = "";
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $term = trim($_POST['term'] ?? '');
            $categoryId = $_POST['category_id'] ?? null;
            $priority = $_POST['priority'] ?? null;
            $status = $_POST['status'] ?? null;

            // If term is empty, redirect to task list
            if ($term) {
                $results = Task::search($_SESSION['user_id'], $term, $categoryId, $priority, $status);
            } else {
                header('Location: index.php?action=tasks');
                exit;
            }
        }
    
        include __DIR__ . '/../views/search_task.php';
    }

    public static function report() {
        self::checkLogin();
    
        // Retrieve aggregated task statistics
        $statusCounts = Task::getStatusCounts($_SESSION['user_id']);
        $overdueCount = Task::getOverdueCount($_SESSION['user_id']);
        $categorySummary = Task::getCategorySummary($_SESSION['user_id']);
    
        include __DIR__ . '/../views/report.php';
    }

    public static function exportCSV() {
        self::checkLogin();
        $tasks = Task::getAll($_SESSION['user_id']);

        // Set headers to prompt file download as CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=tasks_export.csv');

        $output = fopen('php://output', 'w');

        // Write column headers
        fputcsv($output, ['Name', 'Description', 'Category', 'Priority', 'Deadline', 'Status']);

        // Write each task as a row
        foreach ($tasks as $task) {
            fputcsv($output, [
                $task['title'],
                $task['description'],
                $task['category_name'] ?? '',
                $task['priority'],
                $task['due_date'],
                $task['status']
            ]);
        }

        fclose($output);
        exit;
    }

    public static function delete() {
        self::checkLogin();
        $id = $_GET['id'] ?? null;
        Task::delete($id, $_SESSION['user_id']);
        header('Location: index.php?action=tasks');
        exit;
    }

    public static function profile() {
        self::checkLogin();

        $userId = $_SESSION['user_id'];
        $user = User::getUserById($userId);
        $username = $user['username'] ?? 'Unknown';

        // Get task statistics for user profile
        require_once __DIR__ . '/../models/Task.php';
        $statusCounts = Task::getStatusCounts($userId);
        $total = array_sum($statusCounts);

        $done = $statusCounts['done'] ?? 0;
        $inProgress = $statusCounts['in_progress'] ?? 0;
        $todo = $statusCounts['todo'] ?? 0;

        include __DIR__ . '/../views/profile.php';
    }
}

?>