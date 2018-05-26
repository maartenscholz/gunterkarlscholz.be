<?php /** @var \Gks\Domain\Model\Work $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('admin/app', [
    'title' => 'Work images',
]) ?>

<div class="row">
    <div class="col s12">
        <h1><?= $work->getTitle()->getValue('en_US') ?></h1>
        <form action="/admin/works/<?= $work->getId() ?>/images" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
            <div class="input-field file-field">
                <div class="btn-small">
                    <span>Add an image</span>
                    <input type="file" name="image">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <div class="input-field">
                <button type="submit" class="btn">Submit</button>
                <a href="/admin/works" class="btn-flat">back</a>
            </div>
        </form>
        <hr>
        <div class="row">
            <?php foreach ($work->getImages() as $image): ?>
                <div class="col s12 m3 l2">
                    <div class="card">
                        <div class="card-image">
                            <img
                                    class="responsive-img"
                                    src="/image<?= $imageUrlBuilder->getUrl($image->getFilename(), ['w' => 500, 'h' => 500, 'fit' => 'crop', 'border' => '10,000']) ?>"
                                    alt=""
                            >
                        </div>
                        <div class="card-action">
                            <form action="/admin/works/<?= $work->getId() ?>/images/<?= $image->getId() ?>"
                                  method="post">
                                <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
                                <button type="submit" class="btn-flat">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
