<?php
session_start();

// Veritabanı bağlantısını dahil et
require_once __DIR__ . '/../config/database.php';

// $pdo'nun geldiğini kontrol et
if(!isset($pdo)) {
    die("Veritabanı bağlantısı kurulamadı!");
}

if(isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if($action == 'register') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm = $_POST['confirm_password'];
            
            $errors = [];
            if($password !== $confirm) {
                $errors[] = "Şifreler eşleşmiyor!";
            }
            if(strlen($username) < 3) {
                $errors[] = "Kullanıcı adı en az 3 karakter olmalı!";
            }
            if(strlen($password) < 4) {
                $errors[] = "Şifre en az 4 karakter olmalı!";
            }
            
            if(empty($errors)) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                try {
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                    $stmt->execute([$username, $email, $hashed]);
                    $_SESSION['success'] = "Kayıt başarılı! Giriş yapabilirsiniz.";
                    header('Location: ../views/login.php');
                    exit();
                } catch(PDOException $e) {
                    $errors[] = "Bu kullanıcı adı veya e-posta zaten kullanılıyor!";
                }
            }
            $_SESSION['errors'] = $errors;
            header('Location: ../views/register.php');
            exit();
        }
    }
    elseif($action == 'login') {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: ../views/dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = "Kullanıcı adı veya şifre hatalı!";
                header('Location: ../views/login.php');
                exit();
            }
        }
    }
    elseif($action == 'logout') {
        session_destroy();
        header('Location: ../views/index.php');
        exit();
    }
}
?>