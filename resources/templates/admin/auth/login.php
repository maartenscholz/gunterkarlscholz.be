<?php $this->layout('admin/app', [
    'title' => 'Login',
]) ?>

<br><br><br>
<div class="row">
    <div class="col s6 offset-s3">
        <?php if ($message): ?>
            <div class="alert alert-danger">
                <?= $message ?>
            </div>
        <?php endif ?>

        <form action="/login" method="post">
            <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
            <div class="input-field">
                <input type="text" name="username" id="username" value="<?= isset($input) ? $input['username'] : '' ?>">
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" id="password">
                <label for="password">Password</label>
            </div>
            <div class="input-field">
                <input type="submit" value="Login" class="btn">
            </div>
        </form>
    </div>
</div>
