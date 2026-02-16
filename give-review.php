<?php
session_start();
include 'config/db_connection.php';

//  REQUIRE LOGIN

if (!isset($_SESSION['user_id'])) {

    // store return URL so user comes back after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    header("Location: login.php");
    exit;
}

$type = $_GET['type'] ?? '';
$item_id = (int) ($_GET['id'] ?? 0);

if ($type !== 'music' || $item_id <= 0) {
    die("Invalid request.");
}

//  FETCH TRACK INFO
$stmt = mysqli_prepare(
    $con,
    "SELECT title FROM musics WHERE id=? LIMIT 1"
);
mysqli_stmt_bind_param($stmt, "i", $item_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$music = mysqli_fetch_assoc($result);

if (!$music) {
    die("Track not found.");
}

// HANDLE SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rating = (int) $_POST['rating'];
    $review = trim($_POST['review']);
    $user_id = $_SESSION['user_id'];

    if ($rating < 1 || $rating > 5) {
        $error = "Please select a valid rating.";
    } else {

        $stmt = mysqli_prepare(
            $con,
            "INSERT INTO reviews
            (user_id, item_type, item_id, review, rating)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "isisi",
            $user_id,
            $type,
            $item_id,
            $review,
            $rating
        );

        mysqli_stmt_execute($stmt);

        header("Location: index.php?review=success");
        exit;
    }
}
?>

<?php include 'base/header.php'; ?>

<style>
    :root {
        --primary: #6f42c1;
        --dark-bg: #0f0f1a;
        --card-bg: white;
        --text-light: black;
        --text-muted: #bcbcbc;
    }

    .container.card-theme {
        max-width: 600px;
    }

    .card-theme .card {
        background-color: var(--card-bg);
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);
        border-radius: 0.5rem;
    }

    .card-theme h4 {
        color: var(--primary);
    }

    .card-theme label {
        color: var(--text-light);
    }

    .card-theme select.form-control,
    .card-theme textarea.form-control {

        border: 1px solid #3a3a50;
    }

    .card-theme select.form-control option {
        color: var(--text-light);
    }

    .card-theme .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .card-theme .btn-primary:hover {
        background-color: #580f9c;
        border-color: #580f9c;
    }

    .card-theme .alert-danger {
        background-color: #7a1a2e;
        color: var(--text-light);
        border: none;
    }

    textarea {
        resize: none;
    }
</style>

<div class="container mt-5 mb-5 card-theme">
    <div class="card shadow">
        <div class="card-body p-4">

            <h4 class="mb-3">Review Track</h4>

            <p class="text-muted mb-4">
                You are reviewing:<br>
                <strong><?= htmlspecialchars($music['title']) ?></strong>
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rating</label>
                    <select name="rating" class="form-control" required>
                        <option value="">Select rating</option>
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                        <option value="4">⭐⭐⭐⭐ Very Good</option>
                        <option value="3">⭐⭐⭐ Good</option>
                        <option value="2">⭐⭐ Fair</option>
                        <option value="1">⭐ Poor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Review</label>
                    <textarea name="review" class="form-control" rows="4"
                        placeholder="Share your thoughts..."></textarea>
                </div>

                <button class="btn btn-primary w-100">
                    Submit Review
                </button>

            </form>

        </div>
    </div>
</div>

<?php include 'base/footer.php'; ?>