<?php
header('Content-Type: application/json');
require_once 'db.php';

$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'] ?? null;
$password = $input['password'] ?? null;

if(!$email || !$password){
  http_response_code(400);
  echo json_encode(["error" => "Correo y contraseña son obligatorios"]);
  exit;
}

try{
  $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
  $stmt->execute(['email' => $email]);
  
  if($stmt->fetch()){
    http_response_code(409);
    echo json_encode(["error" => "El correo ya está en uso"]);
    exit;
  }

  $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
  $stmt->execute([
    'email' => $email,
    'password' => $password
  ]);

  echo json_encode([
    "success" => true,
    "message" => "Usuario registrado con éxito"
  ]);
}catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Error al registrar el usuario: " . $e->getMessage()]);
}
?>
