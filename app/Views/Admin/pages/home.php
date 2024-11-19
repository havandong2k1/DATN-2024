<h1>Dashboard</h1>

<div class="row dash-row">
    <div class="col-xl-6 rounded-4">
        <div class="stats stats-primary shadow-lg p-3 mb-5 rounded-4">
            <h3 class="stats-title">Tổng người dùng</h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?php echo isset($totalUsers) ? $totalUsers : 0; ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 rounded-4">
        <div class="stats stats-success shadow-lg p-3 mb-5 rounded-4">
            <h3 class="stats-title">Số lượng sản phẩm</h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?php echo isset($totalProduct) ? $totalProduct : 0; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 rounded-4">
        <div class="stats stats-warning shadow-lg p-3 mb-5 rounded-4">
            <h3 class="stats-title">Số lượng bài viết</h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?php echo isset($totalBlog) ? $totalBlog : 0; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 rounded-4">
        <div class="stats shadow-lg p-3 mb-5 rounded-4">
            <h3 class="stats-title">Số lượng đơn hàng đã đặt</h3>
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stats-data">
                    <div class="stats-number"><?php echo isset($totalOrders) ? $totalOrders : 0; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
