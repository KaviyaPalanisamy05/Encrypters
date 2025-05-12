<?php
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Invalid input"]);
  exit;
}

$identifier = $data['identifier'];

// Load user data
$users = json_decode(file_get_contents("users.json"), true);
$user = null;

foreach ($users as $u) {
    if ($u['username'] === $identifier || $u['email'] === $identifier) {
        $user = $u;
        break;
    }
}

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit;
}

// Extract data for signature verification
$signature = base64_decode($data["response"]["signature"]);
$clientDataJSON = base64_decode($data["response"]["clientDataJSON"]);
$authenticatorData = base64_decode($data["response"]["authenticatorData"]);

// Verify the signature (placeholder logic)
$isValidSignature = verifySignature(
    $signature,
    $clientDataJSON,
    $authenticatorData,
    base64_decode($user["public_key"])
);

if ($isValidSignature) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid signature"]);
}

// Placeholder function — replace with real logic or WebAuthn library
function verifySignature($signature, $clientDataJSON, $authenticatorData, $publicKey) {
    // In a real app, verify using cryptographic functions.
    return true; // Replace with actual logic
}

session_start();
$_SESSION['username'] = $user['username'];
