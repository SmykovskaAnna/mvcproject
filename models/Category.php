<?php
require_once __DIR__ . '/../config.php';

class Category {
    public static function add($userId, $name) {
        $pdo = getPDO();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE user_id = ? AND name = ?");
        $stmt->execute([$userId, $name]);
        if ($stmt->fetchColumn() > 0) {
            return "A category with this name already exists.";
        }

        $stmt = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
        $stmt->execute([$userId, $name]);
        return true;
    }

    public static function getAll($userId) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}

?>