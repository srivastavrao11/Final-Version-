<?php
include 'db.php';

$search = "";
$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$offset = ($page - 1) * $limit;

if(isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if (!empty($search)) {

    $searchTerm = "%" . $search . "%";

    $stmt = $conn->prepare("SELECT * FROM posts
                            WHERE title LIKE ?
                            OR content LIKE ?
                            ORDER BY created_at DESC
                            LIMIT ? OFFSET ?");

    $stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);

} else {

    $stmt = $conn->prepare("SELECT * FROM posts
                            ORDER BY created_at DESC
                            LIMIT ? OFFSET ?");

    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();

$result = $stmt->get_result();
if (!empty($search)) {

    $countStmt = $conn->prepare("SELECT COUNT(*) as total
                                 FROM posts
                                 WHERE title LIKE ?
                                 OR content LIKE ?");

    $countStmt->bind_param("ss", $searchTerm, $searchTerm);

} else {

    $countStmt = $conn->prepare("SELECT COUNT(*) as total FROM posts");
}

$countStmt->execute();

$countResult = $countStmt->get_result();

$countRow = $countResult->fetch_assoc();

$totalPosts = $countRow['total'];

$totalPages = ceil($totalPosts / $limit);
?>

<!DOCTYPE html>
<html>
<head>

    <title>All Posts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body{
        background-color:#f8f9fa;
    }

    .card{
        border:none;
        border-radius:10px;
        box-shadow:0 2px 10px rgba(0,0,0,0.1);
    }

    .card:hover{
        transform:translateY(-3px);
        transition:0.3s;
    }

    h2{
        font-weight:bold;
    }

    .btn{
        margin-right:5px;
    }
    </style>

</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">
        All Posts
    </h2>

    <a href="dashboard.php" class="btn btn-primary mb-3">
        Dashboard
    </a>
    <form method="GET" class="mb-4">

    <div class="input-group">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search posts..."
            value="<?php echo $search; ?>">

        <button class="btn btn-success">
            Search
        </button>

    </div>

</form>

<?php
if(mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-warning'>No posts found.</div>";
}
?>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card p-3 mb-3">

            <h3>
                <?php echo $row['title']; ?>
            </h3>

            <p>
                <?php echo $row['content']; ?>
            </p>

            <small>
                <?php echo $row['created_at']; ?>
            </small>

            <br><br>

            <a href="edit.php?id=<?php echo $row['id']; ?>"
               class="btn btn-warning">

                Edit

            </a>

            <a href="delete.php?id=<?php echo $row['id']; ?>"
               class="btn btn-danger">

                Delete

            </a>

        </div>

    <?php } ?>
    <nav>

<ul class="pagination justify-content-center">

<?php for($i = 1; $i <= $totalPages; $i++) { ?>

<li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">

<a class="page-link"
   href="?search=<?php echo $search; ?>&page=<?php echo $i; ?>">

   <?php echo $i; ?>

</a>

</li>

<?php } ?>

</ul>

</nav>

</div>

</body>
</html>