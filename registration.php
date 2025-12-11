<?php
echo "ma eta puge";
// Get POST values
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";

// ERROR HANDLING
if (empty($name)) {
    header("Location: registration.html?error=Name is required");
    exit;
}

if (empty($email)) {
    header("Location: registration.html?error=Email is required");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: registration.html?error=Invalid email format");
    exit;
}

if (empty($password)) {
    header("Location: registration.html?error=Password is required");
    exit;
}

if (strlen($password) < 6) {
    header("Location: registration.html?error=Password must be at least 6 characters");
    exit;
}

if ($password !== $confirmPassword) {
    header("Location: registration.html?error=Passwords do not match");
    exit;
}

// JSON FILE
$file = "user.json";

// Create file if not exists
if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

// Read JSON
$data = file_get_contents($file);
$users = json_decode($data, true);

if (!is_array($users)) {
    $users = [];
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Create new user
$newUser = [
    "name" => $name,
    "email" => $email,
    "password" => $hashedPassword
];

// Add user to array
$users[] = $newUser;

// Write to JSON file
if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT))) {
    header("Location: registration.html?success=1");
    exit;
} else {
    header("Location: registration.html?error=Failed to write to users.json");
    exit;
}

?>
