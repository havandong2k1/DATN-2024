<div class="dash-content">
    <h1 class="dash-title">Trang chủ / Đánh giá</h1>
    <script src="public/vendor/toastr/build/toastr.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <?= view('messages/message') ?>
            <div class="card easion-card rounded-4">
                <div class="card-header rounded-4">
                    <div class="easion-card-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="easion-card-title">Danh sách đánh giá</div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="cell-border stripe">
                    <thead>
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Hình ảnh</th>
                                <th class="text-center" scope="col">Phản hồi</th>
                                <th class="text-center" scope="col">Đánh giá</th>
                                <th class="text-center" scope="col">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataReview as $review): ?>
                                <tr>
                                    <td class="text-center"><?= $review['id']; ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($review['images'])): ?>
                                            <img src="<?= base_url('uploads/' . $review['images']); ?>" alt="Product Image" style="max-width: 100px; height: auto;">
                                        <?php else: ?>
                                            <span>Không có ảnh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= $review['review']; ?></td>
                                    <td class="text-center">
                                        <div class="star-rating">
                                            <?php
                                                $rating = $review['rating'];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        echo '<span class="star">&#9733;</span>';
                                                    } else {
                                                        echo '<span class="empty-star">&#9733;</span>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $review['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?= $this->include("Modals/Order/delete") ?>
<script>
    $(document).ready(function() {
        $('.___js-delete-blog').on('click', function() {
            const id = $(this).data('id');
            console.log(id);
            $('.Order_id_delete').val(id);
            $('#confirmDeleteOrder').modal('show');
        });
    });
</script>
<style>/* Star rating styles */
.star-rating {
    display: inline-block;
    font-size: 20px;
    color: #d3d3d3; /* Gray color for empty stars */
}

.star-rating .star {
    color: #ffcc00; /* Yellow color for filled stars */
}

.star-rating .empty-star {
    color: #d3d3d3; /* Gray color for empty stars */
}
</style>