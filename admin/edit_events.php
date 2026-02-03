<?php
include "./auth.php";
include "../config/db_connection.php";

$id = intval($_GET['id'] ?? 0);

// Fetch event
$event = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM events WHERE id=$id"));

if (!$event) {
    die("Event not found.");
}

// Handle update
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $date = $_POST['event_date'];

    $imgName = $event['image']; // Keep old image by default

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imgName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = "../media/" . $imgName;
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($_FILES['image']['type'], $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Optionally delete old image
                if (file_exists("../media/" . $event['image'])) {
                    unlink("../media/" . $event['image']);
                }
            } else {
                $error = "Failed to upload new image.";
            }
        } else {
            $error = "Invalid image type. Only JPG, PNG, GIF allowed.";
        }
    }

    if (!isset($error)) {
        mysqli_query($con, "
            UPDATE events
            SET title='$title', location='$location', event_date='$date', image='$imgName'
            WHERE id=$id
        ");
        header("Location: all_events.php");
        exit;
    }
}
?>

<?php include "./base/header.php"; ?>

<!-- Main content wrapper to avoid sidebar overlap -->
<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h3>Edit Event</h3>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Date & Time</label>
                <input type="datetime-local"
                       name="event_date"
                       value="<?= date('Y-m-d\TH:i', strtotime($event['event_date'])) ?>"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Image</label><br>
                <img src="../media/<?= $event['image'] ?>" width="120" style="margin-bottom:10px;"><br>
                <input type="file" name="image" class="form-control">
            </div>

            <button name="update" class="btn btn-warning">Update</button>
            <a href="all_events.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>

<?php include "./base/footer.php"; ?>
