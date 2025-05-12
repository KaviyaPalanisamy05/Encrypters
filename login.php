<?php
$data = json_decode(file_get_contents("php://input"), true);
$identifier = $data['identifier']; // Can be username or email

$users = json_decode(file_get_contents("users.json"), true);

$user = null;
foreach ($users as $u) {
    if ($u['username'] === $identifier || $u['email'] === $identifier) {
        $user = $u;
        break;
    }
}

if (!$user) {
    echo json_encode([]); // User not found
    exit;
}

// Send user credential data (e.g., for WebAuthn)
echo json_encode([
    "credential_id" => $user['credential_id'],
    "public_key" => $user['public_key']
]);
