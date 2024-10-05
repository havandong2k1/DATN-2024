<?php

namespace App\Controllers;

use App\Models\OrderModel;

class PaymentController extends BaseController
{
    public function checkout()
    {
        $orderModel = new OrderModel();

        // Lấy thông tin từ form thanh toán
        $orderDesc = $this->request->getPost('order_desc');
        $totalAmount = $this->request->getPost('total_amount');
        $customer_id = session()->get('customer_id'); // ID khách hàng từ session

        // Tạo đơn hàng trong DB với trạng thái 'pending'
        $orderId = $orderModel->createOrder([
            'customer_id' => $customer_id,
            'order_desc' => $orderDesc,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending'
        ]);

        // Chuẩn bị dữ liệu thanh toán cho VNPAY
        $vnp_TmnCode = "YOUR_TMN_CODE"; // Mã website của bạn tại VNPAY
        $vnp_HashSecret = "YOUR_HASH_SECRET"; // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL thanh toán của VNPAY
        $vnp_Returnurl = base_url('payment/callback'); // URL callback sau khi thanh toán xong
        $vnp_TxnRef = $orderId; // Mã đơn hàng
        $vnp_OrderInfo = $orderDesc; // Mô tả đơn hàng
        $vnp_Amount = $totalAmount * 100; // Đơn vị là VND, nhân 100 do VNPAY yêu cầu đơn vị là đồng

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        // Tạo chuỗi URL và mã hóa
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        // Chuyển hướng người dùng đến cổng thanh toán VNPAY
        return redirect()->to($vnp_Url);
    }

    public function callback()
    {
        // Xử lý callback từ VNPAY sau khi thanh toán
        $vnp_HashSecret = "YOUR_HASH_SECRET"; // Chuỗi bí mật đã khai báo
        $vnp_SecureHash = $_GET['vnp_SecureHash'];

        unset($_GET['vnp_SecureHashType']);
        unset($_GET['vnp_SecureHash']);
        ksort($_GET);
        $hashData = "";
        foreach ($_GET as $key => $value) {
            $hashData .= '&' . $key . "=" . $value;
        }
        $hashData = trim($hashData, '&');
        $secureHash = hash('sha256', $vnp_HashSecret . $hashData);

        $orderModel = new OrderModel();

        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                // Cập nhật trạng thái đơn hàng khi thanh toán thành công
                $orderModel->updateOrderStatus($_GET['vnp_TxnRef'], 'paid');
                echo "Thanh toán thành công!";
            } else {
                // Giao dịch thất bại
                $orderModel->updateOrderStatus($_GET['vnp_TxnRef'], 'failed');
                echo "Thanh toán thất bại!";
            }
        } else {
            echo "Chuỗi mã hóa không hợp lệ!";
        }
    }
}
