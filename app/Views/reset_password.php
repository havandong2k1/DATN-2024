<?php include 'templates/header.php'; ?>

<div class="container">
    <div class="row d-flex justify-content-center align-items-center mt-5">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Đặt lại mật khẩu</h3>

            <?php if (session()->getFlashdata("msg_success")): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata("msg_success") ?>
                </div>
            <?php elseif (session()->getFlashdata("msg_error")): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata("msg_error") ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('password/update') ?>" method="post">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                <input type="hidden" name="token" value="<?= $token ?>"/>

                <div class="form-outline mb-4">
                    <label class="form-label" for="password">Mật khẩu mới</label>
                    <input type="password" name="password" id="password" class="form-control" required/>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
