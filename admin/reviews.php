<?php
include 'auth.php';
include '../config/db_connection.php';

$reviews = mysqli_query($con, "
    SELECT 
        reviews.*,
        users.name,
        users.email,
        musics.title AS music_title
    FROM reviews
    JOIN users ON reviews.user_id = users.id
    LEFT JOIN musics ON reviews.item_id = musics.id
    WHERE reviews.item_type = 'music'
    ORDER BY reviews.id DESC
");
?>

<?php include './base/header.php'; ?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid mt-4">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Reviews & Ratings</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle justify-content-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>User</th>
                                    <th class="d-none d-sm-table-cell">Email</th>
                                    <th>Song</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th class="d-none d-md-table-cell">Date</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (mysqli_num_rows($reviews) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($reviews)): ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars($row['name']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['email']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($row['music_title'] ?? 'Unknown'); ?>
                                            </td>

                                            <td>
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="<?= $i <= $row['rating']
                                                        ? 'ri-star-fill text-warning'
                                                        : 'ri-star-line text-muted' ?>"></i>
                                                <?php endfor; ?>
                                            </td>

                                            <td>
                                                <di>
                                                    <?= htmlspecialchars($row['review']); ?>
                                                </di>
                                            </td>

                                            <td>
                                                <?= date('d M Y', strtotime($row['created_at'])); ?>
                                            </td>

                                            <td>
                                                <a href="delete_review.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete this review?')">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="text-muted py-4">
                                            No reviews found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include './base/footer.php'; ?>