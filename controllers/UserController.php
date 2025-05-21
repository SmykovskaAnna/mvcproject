<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    // Handles user registration form submission and validation
    public static function register() {
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            // Validate username length
            if (strlen($username) < 3 || strlen($username) > 50) {
                $error = "The login must contain between 3 and 50 characters.";
            } 
            // Validate email format
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Incorrect email.";
            } 
            // Validate password length
            elseif (strlen($password) < 6) {
                $error = "The password must be at least 6 characters long.";
            } else {                
                // Attempt to register user via User model
                $result = User::register($username, $email, $password);
                if ($result === true) {
                    // Redirect to login on successful registration
                    header('Location: index.php?action=login');
                    exit;
                } else {
                    $error = $result; // Error message from User::register
                }
            }
        }

        include __DIR__ . '/../views/register.php'; // Show registration form
    }

    // Handles user login form submission and validation
    public static function login() {
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // Attempt to log in via User model
            $result = User::login($username, $password);
            if ($result === true) {
                // Redirect to category list after successful login
                header('Location: index.php?action=category_list');
                exit;
            } else {
                $error = $result; // Error message from User::login
            }
        }

        include __DIR__ . '/../views/login.php'; // Show login form
    }

    // Logs out the user by destroying the session and redirecting to login
    public static function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}

?>