<div class="container-fluid">
    <h1 class="dash-title">Trang chủ / Tài khoản</h1>
    <script src="public/vendor/toastr/build/toastr.min.js"></script>
    <div class="row">
        <div class="col-lg-12">
        <?= view('messages/message') ?>
            <div class="card easion-card rounded-4">
                <div class="card-header rounded-4">
                    <div class="easion-card-icon">
                        <i class="fas fa-table"></i>
                    </div>
                    <div class="easion-card-title">Danh sách tài khoản</div>
                </div>
                <div class="card-body ">
                    <table id="datatable" class="cell-border stripe">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Status</th>
                                <th scope="col">Mật khẩu</th>
                                <th scope="col">Email</th>
                                <th scope="col">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td class="text-center"><?= $user['status_users'] ?></td>
                                    <td><?= $user['password'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td class="text-center">
                                        <a href="admin/user/edit/<?= $user['id'] ?>" class="btn btn-primary btn-sm ___js-edit-user"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm ___js-delete-user" data-id="<?= @$user['id'];?>">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?= $this->include("Modals/Users/delete") ?>
<script>
    $('.___js-delete-user').on('click',function(){
        // Lấy dữ liệu từ nút xóa
        const id = $(this).data('id');
        console.log(id);
        // Đặt dữ liệu vào Form xóa
        $('.user_id_delete').val(id);
        // Gọi Modal xóa
        $('#confirmDeleteUser').modal('show');
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