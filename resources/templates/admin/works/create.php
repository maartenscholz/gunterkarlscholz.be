<?php $this->layout('admin/app', [
    'title' => 'Add work',
]) ?>

<div class="row">
    <form action="/admin/works" method="post">
        <?= $this->fetch('admin::works/_form', compact('input')) ?>
    </form>
</div>
