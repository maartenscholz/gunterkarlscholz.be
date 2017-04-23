<?php $this->layout('admin/app', [
    'title' => 'Login',
]) ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Login
            </div>
            <div class="panel-body">
                <?php if ($message): ?>
                    <div class="alert alert-danger">
                        <?= $message ?>
                    </div>
                <?php endif ?>

                <form action="/login" method="post">
                    <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= isset($input) ? $input['username'] : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <input type="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
