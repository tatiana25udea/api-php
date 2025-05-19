<?php
header('Content-Type: application/json');
require_once 'db.php';

$input = json_decode(file_get_contents("php://input"), true);

$email = $input['email'] ?? null;
$password = $input['password'] ?? null;

if(!$email || !$password) {
    http_response_code(400);
    echo json_encode(["error" => "Correo y contraseña son obligatorios"]);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && $password == $user['password']){
  echo json_encode([
    "success" => true,
    "user" => [
      "id" => $user['id'],
      "email" => $user['email']
    ]
  ]);
} else {
  http_response_code(401);
  echo json_encode(["error" => $password]);
}

?>
