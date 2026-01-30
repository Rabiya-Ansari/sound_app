<?php
session_start();
include '../config/db_connection.php';

//log in role check 
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user'){
    header("Location: ../login.php");
    exit;
}

$uid = $_SESSION['user_id'];


$user_query = mysqli_query($con, "SELECT name FROM users WHERE id = $uid LIMIT 1");
$user = mysqli_fetch_assoc($user_query);
$username = $user['name'] ?? 'User';


if(isset($_POST['submit'])){
    $review = mysqli_real_escape_string($con,$_POST['review']);
    $rating = intval($_POST['rating']);

    mysqli_query($con,"INSERT INTO reviews (user_id,review,rating,created_at)
                       VALUES ($uid,'$review',$rating,NOW())");

    header("Location: dashboard.php"); 
    exit;
}

// Fetch user reviews
$reviews = mysqli_query($con,"SELECT * FROM reviews WHERE user_id = $uid ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($username) ?> Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Remix Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet">

    <style>
        textarea { width: 100%; height: 100px; padding: 8px; }
        .review-form { margin-bottom: 30px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">👤 <?= htmlspecialchars($username) ?>'s Dashboard</h3>
        <a href="/sound/user/logout.php" class="btn btn-outline-danger btn-sm">
            <i class="ri-logout-box-line"></i> Logout
        </a>
    </div>

    <!-- Add Review Form -->
    <div class="card shadow-sm review-form">
        <div class="card-header bg-white">
            <h5 class="mb-0">➕ Add New Review</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select" required>
                        <option value="">Select Rating</option>
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★ (4)</option>
                        <option value="3">★★★ (3)</option>
                        <option value="2">★★ (2)</option>
                        <option value="1">★ (1)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Review</label>
                    <textarea name="review" placeholder="Write your review..." required></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">
                    <i class="ri-send-plane-line"></i> Submit Review
                </button>
            </form>
        </div>
    </div>

    <!-- Reviews Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">⭐ My Reviews</h5>
        </div>

        <div class="card-body">
            <?php if(mysqli_num_rows($reviews) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($reviews)): ?>
                    <div class="border rounded p-3 mb-3">
                        <!-- Rating -->
                        <div class="mb-2">
                            <?php
                            for($i=1; $i<=5; $i++){
                                echo $i <= $row['rating']
                                    ? '<i class="ri-star-fill text-warning"></i>'
                                    : '<i class="ri-star-line text-muted"></i>';
                            }
                            ?>
                        </div>

                        <p class="mb-1"><?= htmlspecialchars($row['review']); ?></p>

                        <small class="text-muted">
                            <i class="ri-calendar-line"></i>
                            <?= date('d M Y', strtotime($row['created_at'])); ?>
                        </small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted text-center mb-0">
                    You haven’t added any reviews yet.
                </p>
            <?php endif; ?>
        </div>
    </div>

</div>

</body>
</html>
