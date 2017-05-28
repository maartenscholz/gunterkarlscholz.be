<?php /** @var \Gks\Domain\Works\Work[] $works */ ?>

<?php $this->layout('admin/app', [
    'title' => 'Works',
]) ?>

<div class="row">
    <a href="/admin/works/create" class="btn btn-primary">Add work</a>

    <br><br>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Dimensions</th>
                <th></th>
            </tr>
        </thead>
        <?php if (empty($works)): ?>
            <tr>
                <td colspan="9999"> No works found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($works as $work): ?>
                <tr>
                    <td><?= $work->getTitle()->getValue('en_US') ?> / <?= $work->getTitle()->getValue('nl_BE') ?></td>
                    <td><?= $work->getType()->getValue() ?></td>
                    <td><?= $work->getDimensions() ?></td>
                    <td>
                        <a href="/admin/works/<?= $work->getWorkId() ?>/edit">edit</a> -
                        <a href="/admin/works/<?= $work->getWorkId() ?>/images">images</a> -
                        <a href="/admin/works/<?= $work->getWorkId() ?>/destroy">delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
