<?php 
session_start();

// get the input from fetch() from signup.js and convert into PHP array
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
  http_response_code(400);
  echo json_encode(["message" => "Invalid input"]);
  exit;
}

// store username in session (after $data is available)
$_SESSION['username'] = $data['username'];

// file to store registered users
$file = "users.json";
// load existing users or initialize array
$users = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

// append new user
$users[] = [
  "email" => $data["email"],
  "username" => $data["username"],
  "number" => $data["number"],
  "credential_id" => $data["id"], // WebAuthn credential ID
  "public_key" => $data["response"]["attestationObject"] // WebAuthn key
];

// save updated users list
file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));

// send success message
echo json_encode(["message" => "User registered successfully"]);
?>
