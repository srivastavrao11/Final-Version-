<?php
session_start();

include 'db.php';

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    die("Username and Password are required.");
}
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

$stmt->bind_param("s", $username);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            $_SESSION['username'] = $username;

            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");

        } else {
            echo "Invalid Password";
        }

    } else {
        echo "User Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card p-4 shadow">

                <h2 class="text-center mb-4">
                    Login
                </h2>

                <form method="POST">

                    <div class="mb-3">

                        <input type="text"
                               name="username"
                               class="form-control"
                               placeholder="Enter Username"
                               required>

                    </div>

                    <div class="mb-3">

                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter Password"
                               required>

                    </div>

                    <div class="d-grid">

                        <button type="submit"
                                name="login"
                                class="btn btn-primary">

                            Login

                        </button>

                    </div>

                </form>

                <div class="text-center mt-3">

                    <a href="register.php">
                        Register Here
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>