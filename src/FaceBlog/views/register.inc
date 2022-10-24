<?php $render('partial/header', $data); ?>

    <h1 class="mb-3">Register</h1>

<?php $beginForm('User', 'Register', method: 'post'); ?>
    <div class="mb-3">
        <label for="userName" class="form-label">Username</label>
        <input class="form-control" id="userName" name="un" value="<?php $htmlOut($data['userName']); ?>"
               autocomplete="off">
    </div>
    <div class="mb-3">
        <label for="nickName" class="form-label">Nickname</label>
        <input class="form-control" id="nickName" name="ni" value="<?php $htmlOut($data['nickName']); ?>"
               autocomplete="off">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input class="form-control" id="password" name="pwd" type="password"
               value="<?php $htmlOut($data['password']); ?>" autocomplete="off">
        <div class="form-text">A password with a minimum length of 4 characters is required.</div>
    </div>
    <div class="mb-3">
        <label for="passwordConfirmation" class="form-label">Confirm password</label>
        <input class="form-control" id="passwordConfirmation" name="pwdConf" type="password"
               value="<?php $htmlOut($data['passwordConfirmation']); ?>" autocomplete="off">
    </div>
    <button class="btn btn-outline-primary">Register</button>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>