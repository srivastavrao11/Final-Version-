<?php
include 'db.php';

if (isset($_POST['register'])) {

   $username = trim($_POST['username']);
$passwordInput = trim($_POST['password']);

if (empty($username) || empty($passwordInput)) {
    die("Username and Password are required.");
}

$password = password_hash($passwordInput, PASSWORD_DEFAULT);

   $stmt = $conn->prepare("INSERT INTO users(username, password) VALUES(?, ?)");

$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Registration Successful";
} else {
    echo "Error: " . $stmt->error;
}
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">
        Register
    </h2>

    <form method="POST">

        <div class="mb-3">

            <input type="text"
                   name="username"
                   class="form-control"
                   placeholder="Username"
                   required>

        </div>

        <div class="mb-3">

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Password"
                   required>

        </div>

        <button type="submit"
                name="register"
                class="btn btn-success">

            Register

        </button>

    </form>

</div>

</body>
</html>