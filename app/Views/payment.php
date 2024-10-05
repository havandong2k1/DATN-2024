<?php include 'templates/header.php'; ?>
<form action="/payment/checkout" method="POST">
    <h3>Thông tin thanh toán</h3>
    <div class="form-group">
        <label for="order_desc">Mô tả đơn hàng:</label>
        <input type="text" name="order_desc" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="total_amount">Số tiền thanh toán (VND):</label>
        <input type="number" name="total_amount" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="bank_code">Chọn ngân hàng:</label>
        <select name="bank_code" class="form-control">
            <option value="NCB">Ngân hàng NCB</option>
            <option value="SACOMBANK">Sacombank</option>
            <option value="VIETCOMBANK">Vietcombank</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Thanh toán</button>
</form>
<?= view('templates/footer'); ?>