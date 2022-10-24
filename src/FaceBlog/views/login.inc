<?php $render('partial/header', $data); ?>

    <h1 class="mb-3">Login</h1>

<?php $beginForm('User', 'LogIn', method: 'post'); ?>
    <div class="mb-3">
        <label for="userName" class="form-label">Username</label>
        <input class="form-control" id="userName" name="un" value="<?php $htmlOut($data['userName']); ?>"
               autocomplete="off">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="pwd" autocomplete="off">
    </div>
    <button class="btn btn-outline-primary">Login</button>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>