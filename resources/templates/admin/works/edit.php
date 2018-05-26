<?php /** @var \Gks\Domain\Model\Work $work */ ?>

<?php $this->layout('admin/app', [
    'title' => 'Edit work',
]) ?>

<h1>Edit <?= $work->getTitle()->getValue('en_US') ?></h1>
<form action="/admin/works/<?= $work->getId() ?>" method="post">
    <input type="hidden" name="_method" value="put">
    <?= $this->fetch('admin::works/_form', compact('work')) ?>
</form>
