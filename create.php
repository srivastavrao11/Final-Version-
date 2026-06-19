<?php
session_start();

include 'db.php';
if (!isset($_SESSION['role']) ||
    !in_array($_SESSION['role'], ['admin', 'editor'])) {

    die("Access Denied!");
}

if (isset($_POST['submit'])) {

    $title = trim($_POST['title']);
$content = trim($_POST['content']);

if (empty($title) || empty($content)) {
    die("Title and Content are required.");
}

    $stmt = $conn->prepare("INSERT INTO posts(title, content) VALUES(?, ?)");

$stmt->bind_param("ss", $title, $content);

if ($stmt->execute()) {

    header("Location: index.php");

} else {

    echo "Error: " . $stmt->error;
}
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Create Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">
        Create New Post
    </h2>

    <form method="POST">

        <div class="mb-3">

            <input type="text"
                   name="title"
                   class="form-control"
                   placeholder="Enter Title"
                   required>

        </div>

        <div class="mb-3">

            <textarea name="content"
          class="form-control"
          rows="5"
          placeholder="Enter Content"
          required></textarea>

        </div>

        <button type="submit"
                name="submit"
                class="btn btn-primary">

            Add Post

        </button>

    </form>

</div>

</body>
</html>