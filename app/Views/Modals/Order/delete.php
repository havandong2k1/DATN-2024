<form action="<?= base_url('admin/order/delete') ?>" method="post">
    <div class="modal fade" id="confirmDeleteOrder" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteOrder" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa đơn hàng này?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_order" class="order_id_delete">
                    <a style="background-color: red" href="<?= base_url('admin/order/list') ?>" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                </div>
            </div>
        </div>
    </div>
</form>
