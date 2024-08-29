<form action="<?= site_url('reviews/sendreviews') ?>" method="post">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <span>
       <input value="<?php old('name'); ?>" id="name" type="text" placeholder="Your Name"/>
        <input value="<?php old('email'); ?>" id="email" type="email" placeholder="Email Address"/>
     </span>
    <textarea name="content" id="content"></textarea>
    <b>Đánh giá: </b>
    <button type="submit" class="btn btn-default pull-right">Gửi</button>
</form>
