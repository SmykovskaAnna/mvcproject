<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    // Lists categories for logged-in user with task count for each
    public static function list() {
        self::checkLogin();
        $userId = $_SESSION['user_id'];

        $pdo = getPDO();
        // Select categories and count of user's tasks per category
        $stmt = $pdo->prepare("
            SELECT c.id, c.name, COUNT(t.id) AS task_count
            FROM categories c
            LEFT JOIN tasks t ON c.id = t.category_id AND t.user_id = :user_id
            WHERE c.user_id = :user_id
            GROUP BY c.id
            ORDER BY c.name
        ");
        $stmt->execute([':user_id' => $userId]);
        $categories = $stmt->fetchAll();

        include __DIR__ . '/../views/category_list.php';
    }
    
    // Adds a new category for the logged-in user with validation
    public static function add() {
        self::checkLogin();
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (strlen($name) < 3 || strlen($name) > 50) {
                $error = "The category name must contain between 3 and 50 characters.";
            } else {
                $result = Category::add($_SESSION['user_id'], $name);
                if ($result === true) {
                    header('Location: index.php?action=category_list');
                    exit;
                } else {
                    $error = $result; // Error from Category::add
                }
            }
        }

        include __DIR__ . '/../views/add_category.php';
    }

    // Checks if user is logged in; redirects to login if not
    private static function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    // Edits an existing category owned by the logged-in user with validation
    public static function edit() {
        self::checkLogin();
        $pdo = getPDO();
        $error = "";
        $userId = $_SESSION['user_id'];

        // Redirect if no category ID provided
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=category_list');
            exit;
        }

        $id = (int)$_GET['id'];

        // Fetch category to edit; ensure it belongs to user
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $category = $stmt->fetch();

        // Redirect if category not found or not owned by user
        if (!$category) {
            header('Location: index.php?action=category_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);

            if (strlen($name) < 3 || strlen($name) > 50) {
                $error = "The category name must contain between 3 and 50 characters.";
            } else {
                // Update category name
                $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id AND user_id = :user_id");
                $stmt->execute([':name' => $name, ':id' => $id, ':user_id' => $userId]);
                header('Location: index.php?action=category_list');
                exit;
            }
        }

        include __DIR__ . '/../views/edit_category.php';
    }

    // Deletes a category owned by the logged-in user
    public static function delete() {
        self::checkLogin();
        $pdo = getPDO();
        $userId = $_SESSION['user_id'];

        // Redirect if no category ID provided
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=category_list');
            exit;
        }

        $id = (int)$_GET['id'];

        // Delete category if it belongs to user
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':id' => $id, ':user_id' => $userId]);

        header('Location: index.php?action=category_list');
        exit;
    }
}

?>