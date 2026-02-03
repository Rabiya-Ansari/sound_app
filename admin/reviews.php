<?php
include 'auth.php';
include '../config/db_connection.php';

$reviews = mysqli_query($con, "
    SELECT reviews.*, users.name, users.email 
    FROM reviews
    JOIN users ON reviews.user_id = users.id
    ORDER BY reviews.id DESC
");
?>

<?php include './base/header.php'; ?>

<div class="card shadow-sm">
    <div class="card-body">

        <!-- Table scrolls horizontally on small devices -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th class="d-none d-sm-table-cell">Email</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th class="d-none d-md-table-cell">Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($reviews) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($reviews)): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($row['name']); ?></td>
                                <td class="d-none d-sm-table-cell"><?= htmlspecialchars($row['email']); ?></td>

                                <td>
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $row['rating']
                                            ? '<i class="ri-star-fill text-warning"></i>'
                                            : '<i class="ri-star-line text-muted"></i>';
                                    }
                                    ?>
                                </td>

                                <td style="max-width:300px; word-break:break-word;">
                                    <?= htmlspecialchars($row['review']); ?>
                                </td>

                                <td class="d-none d-md-table-cell">
                                    <?= date('d M Y', strtotime($row['created_at'])); ?>
                                </td>

                                <td>
                                    <a href="delete_review.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this review?')">
                                        <i class="ri-delete-bin-line"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No reviews found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<?php include './base/footer.php'; ?>