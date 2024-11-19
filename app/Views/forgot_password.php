<?php include 'templates/header.php'; ?>

<div class="container">
    <div class="row d-flex justify-content-center align-items-center mt-5">
        <div class="col-md-6">
            <h3 class="text-center mb-4">Quên mật khẩu</h3>

            <?php if (session()->getFlashdata("msg_success")): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata("msg_success") ?>
                </div>
            <?php elseif (session()->getFlashdata("msg_error")): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata("msg_error") ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('forgot-password') ?>" method="post">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>

                <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Example@gmail.com" required/>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Gửi yêu cầu</button>
            </form>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
