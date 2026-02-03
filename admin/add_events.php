<?php
include "./auth.php";
include "../config/db_connection.php";

if(isset($_POST['add_event'])){
    $title = mysqli_real_escape_string($con,$_POST['title']);
    $location = mysqli_real_escape_string($con,$_POST['location']);
    $date = $_POST['event_date'];

    $img = time().$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../media/".$img);

    mysqli_query($con, "
        INSERT INTO events (title, location, event_date, image)
        VALUES ('$title','$location','$date','$img')
    ");

    header("Location: all_events.php");
    exit;
}
?>

<?php include "./base/header.php"; ?>
<div class="main-content" style="margin-left: 250px; padding: 20px;">
    <div class="container mt-4">
        <h3>Add Event</h3>

        <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date & Time</label>
            <input type="datetime-local" name="event_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button name="add_event" class="btn btn-success">Save Event</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
    </div>
</div>


<?php include "./base/footer.php"; ?>
