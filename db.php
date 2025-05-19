<?php
$host = "mainline.proxy.rlwy.net";
$dbname = "railway";
$username = "root";
$password = "QYdzlNVZyPPDoBbrXPemjuKQwZcgRrJI";
$port = 16593;

try{
  $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_decode(["error" => "Database connection failed: " . $e->getMessage()]);
  exit();
}
?>
