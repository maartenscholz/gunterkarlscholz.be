<?php $this->layout('admin/app', [
    'title' => 'Edit work',
]) ?>

<div class="row">
    <form action="/admin/works/<?= $work->getWorkId() ?>" method="post">
        <input type="hidden" name="_method" value="put">
        <?= $this->fetch('admin::works/_form', compact('work')) ?>
    </form>
</div>
