<?php $this->layout('admin/app', [
    'title' => 'Add work',
]) ?>

<h1>Add work</h1>
<form action="/admin/works" method="post">
    <?= $this->fetch('admin::works/_form', compact('input')) ?>
</form>
