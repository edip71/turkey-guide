<?php
session_start();

// Veritabanı bağlantısını dahil et
require_once __DIR__ . '/../config/database.php';

if(!isset($pdo)) {
    die("Veritabanı bağlantısı kurulamadı!");
}

if(isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if($action == 'like') {
        header('Content-Type: application/json');
        
        if(!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Oturum açın']);
            exit();
        }
        
        $city_id = $_POST['city_id'] ?? 0;
        $user_id = $_SESSION['user_id'];
        
        $check = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND city_id = ?");
        $check->execute([$user_id, $city_id]);
        
        if($check->rowCount() > 0) {
            $delete = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND city_id = ?");
            $delete->execute([$user_id, $city_id]);
            $status = 'unliked';
        } else {
            $insert = $pdo->prepare("INSERT INTO likes (user_id, city_id) VALUES (?, ?)");
            $insert->execute([$user_id, $city_id]);
            $status = 'liked';
        }
        
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE city_id = ?");
        $countStmt->execute([$city_id]);
        $total = $countStmt->fetchColumn();
        
        echo json_encode(['status' => $status, 'total_likes' => $total]);
        exit();
    }
    elseif($action == 'add_comment') {
        if(!isset($_SESSION['user_id'])) {
            header('Location: ../views/login.php');
            exit();
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $city_id = $_POST['city_id'];
            $comment = $_POST['comment'];
            $rating = $_POST['rating'];
            
            $stmt = $pdo->prepare("INSERT INTO comments (user_id, city_id, comment, rating) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $city_id, htmlspecialchars($comment), $rating]);
            
            header("Location: ../views/city.php?id=$city_id");
            exit();
        }
    }
    elseif($action == 'delete_comment') {
        header('Content-Type: application/json');
        
        if(!isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Oturum açın']);
            exit();
        }
        
        $comment_id = $_POST['comment_id'] ?? 0;
        $city_id = $_POST['city_id'] ?? 0;
        $user_id = $_SESSION['user_id'];
        
        // Önce yorumun bu kullanıcıya ait olduğunu kontrol et
        $check = $pdo->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
        $check->execute([$comment_id, $user_id]);
        
        if($check->rowCount() > 0) {
            $delete = $pdo->prepare("DELETE FROM comments WHERE id = ?");
            $delete->execute([$comment_id]);
            echo json_encode(['status' => 'success', 'message' => 'Yorum silindi']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Bu yorumu silme yetkiniz yok']);
        }
        exit();
    }
}
?>