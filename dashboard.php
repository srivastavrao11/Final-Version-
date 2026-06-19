<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5 text-center">

    <h2 class="mb-4">
        Welcome <?php echo $_SESSION['username']; ?>
    </h2>

    <a href="create.php"
       class="btn btn-primary">

        Create Post

    </a>

    <br><br>

    <a href="index.php"
       class="btn btn-success">

        View Posts

    </a>

    <br><br>

    <a href="logout.php"
       class="btn btn-danger">

        Logout

    </a>

</div>

</body>
</html>