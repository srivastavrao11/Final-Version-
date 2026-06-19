<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

$post = $result->fetch_assoc();

if (isset($_POST['update'])) {

    $title = trim($_POST['title']);
$content = trim($_POST['content']);

if (empty($title) || empty($content)) {
    die("Title and Content are required.");
}

$stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");

$stmt->bind_param("ssi", $title, $content, $id);

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

    <title>Edit Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">
        Edit Post
    </h2>

    <form method="POST">

        <div class="mb-3">

            <input type="text"
                   name="title"
                   class="form-control"
                   value="<?php echo $post['title']; ?>"
                   required>

        </div>

        <div class="mb-3">

            <textarea name="content"
          class="form-control"
          rows="5"
          required><?php echo $post['content']; ?></textarea>

        </div>

        <button type="submit"
                name="update"
                class="btn btn-warning">

            Update Post

        </button>

    </form>

</div>

</body>
</html>