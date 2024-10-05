<div class="dash-content">
    <h1 class="dash-title">Trang chủ / Bài viết</h1>
    <script src="public/vendor/toastr/build/toastr.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
            <?= view('messages/message') ?>
            <div class="card easion-card rounded-4">
                <div class="card-header rounded-4">
                    <div class="easion-card-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="easion-card-title">Danh sách bài viết</div>
                </div>
                <div class="card-body">
                    <table id="datatable" class="cell-border stripe">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Nội dung</th>
                            <th scope="col">Ảnh Blog</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($blogs) && !empty($blogs)) : ?>
                            <?php foreach ($blogs as $index => $blog) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($blog['title']) ?></td>
                                    <td><?= htmlspecialchars($blog['content']) ?></td>
                                    <td>
                                        <?php if (!empty($blog['image'])): ?>
                                            <!-- Kiểm tra và hiển thị hình ảnh -->
                                            <img src="<?= base_url('public/viewblog/' . $blog['image']); ?>"  height="60" width="60">
                                        <?php else: ?>
                                            <!-- Hiển thị placeholder nếu không có ảnh -->
                                            <img src="<?= base_url('public/viewblog/placeholder.png'); ?>" alt="No image" height="60" width="60">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($blog['created_at'])) ?></td> <!-- Định dạng ngày tháng -->
                                    <td class="text-center">
                                        <a href="admin/blog/edit/<?= $blog['id_blogs'] ?>" class="btn btn-primary btn-sm ___js-edit-blog"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm ___js-delete-blog" data-id="<?= @$blog['id_blogs'];?>"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có bài viết nào</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?= $this->include("Modals/Blog/delete") ?>
<script>
    $('.___js-delete-blog').on('click', function(){
        // Lấy dữ liệu từ nút xóa
        const id = $(this).data('id');
        // Đặt dữ liệu vào Form xóa
        $('.blogs_id_delete').val(id);
        // Gọi Modal xóa
        $('#confirmDeleteBlogs').modal('show');
    });

    $('#datatable').DataTable({
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    var column = this;
                    var title = column.footer().textContent;

                    // Create input element and add event listener
                    $('<input type="text" placeholder="Search ' + title + '" />')
                        .appendTo($(column.footer()).empty())
                        .on('keyup change clear', function () {
                            if (column.search() !== this.value) {
                                column.search(this.value).draw();
                            }
                        });
                });
        }
    });
</script>
