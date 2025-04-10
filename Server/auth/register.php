<?php
require_once('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $message = $_POST['message'];
  $gender = $_POST['gender'] ?? null;

  $stmt = $pdo->prepare("INSERT INTO users (name, email, password, message, gender) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$name, $email, $password, $message, $gender]);

  header("Location: ../pages/login.php?registration=success");
  exit();
}
?>