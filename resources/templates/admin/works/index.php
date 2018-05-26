<?php /** @var \Gks\Domain\Model\Work[] $works */ ?>

<?php $this->layout('admin/app', [
    'title' => 'Works',
]) ?>

<div class="row">
    <div class="col s12">
        <h1>Works</h1>
        <a href="/admin/works/create" class="btn btn-primary">Add work</a>

        <br><br>

        <table class="highlight">
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
                        <td><?= $work->getTitle()->getValue('en_US') ?>
                            / <?= $work->getTitle()->getValue('nl_BE') ?></td>
                        <td><?= $work->getType()->getValue() ?></td>
                        <td><?= $work->getDimensions() ?: '-' ?></td>
                        <td>
                            <a class='dropdown-trigger btn-small' href='#' data-target='dropdown1'><i
                                        class="material-icons">settings</i></a>
                            <ul id='dropdown1' class='dropdown-content'>
                                <li><a href="/admin/works/<?= $work->getId() ?>/images"><i
                                                class="material-icons left">images</i> Images</a></li>
                                <li><a href="/admin/works/<?= $work->getId() ?>/edit"><i
                                                class="material-icons">edit</i> Edit</a></li>
                                <li><a href="/admin/works/<?= $work->getId() ?>/destroy"><i class="material-icons">delete</i>
                                        Delete</a></li>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>
