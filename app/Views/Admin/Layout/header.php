<header class="dash-toolbar">
    <a href="javascript::void()" class="menu-toggle">
        <i class="fas fa-bars"></i>
    </a>
    <a href="javascript::void()" class="searchbox-toggle">
        <i class="fas fa-search"></i>
    </a>

<!--    <form class="searchbox" action="--><?//= site_url('') ?><!--" method="post">-->
<!--        <a href="javascript::void()" class="searchbox-toggle"> <i class="fas fa-arrow-left"></i> </a>-->
<!--        <button type="submit" class="searchbox-submit"> <i class="fas fa-search"></i> </button>-->
<!--        <input type="text" name="keyword" class="searchbox-input" placeholder="Nhập thông tin tìm kiếm">-->
<!--    </form>-->



    <div class="tools">
        <div class="centered-icons">
            <a id="realtime-time"><i class="fa fa-clock-o"></i></a>
            <a id="realtime-date"><i class="fa fa-calendar-o"></i></a>
        </div>
        <div class="dropdown tools-item">
            <a href="#" class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">
                <i class="fas fa-user"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                <a class="dropdown-item" href="javascript:void()">Xin chào, <?= session()->get('admin_name') ?></a>
                <a class="dropdown-item" href="admin/logout">Logout</a>
            </div>
        </div>
    </div>
</header>