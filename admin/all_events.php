<?php
include "./auth.php";
include "../config/db_connection.php";

// auto update passed events
mysqli_query($con, "
    UPDATE events 
    SET status='passed' 
    WHERE event_date < NOW()
");

$events = mysqli_query($con, "SELECT * FROM events ORDER BY event_date DESC");
?>

<?php include "./base/header.php"; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2">
            <!-- Sidebar content here -->
        </div>

        <!-- Main content -->
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>All Events</h3>
                <a href="add_events.php" class="btn btn-primary">+ Add Event</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; while($row = mysqli_fetch_assoc($events)) { ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><img src="../media/<?= $row['image'] ?>" width="60"></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['location'] ?></td>
                            <td><?= date("d M Y h:i A", strtotime($row['event_date'])) ?></td>
                            <td>
                                <span class="badge <?= $row['status']=='upcoming'?'bg-success':'bg-secondary' ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_events.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_events.php?id=<?= $row['id'] ?>"
                                   onclick="return confirm('Delete this event?')"
                                   class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include "./base/footer.php"; ?>
