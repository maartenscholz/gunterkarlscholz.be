<?php /** @var \Gks\Domain\Works\Work $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('admin/app', [
    'title' => 'Work images',
]) ?>

<div class="row">
    <h1><?= $work->getTitle()->getValue('en_US') ?></h1>
    <form action="/admin/works/<?= $work->getWorkId() ?>/images" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_csrf_token" value="<?= $csrf_token ?>">
        <div class="form-group">
            <label for="image">Add an image</label>
            <input type="file" id="image" name="image">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Submit</button>
            <a href="/admin/works" class="btn btn-link">back</a>
        </div>
    </form>
    <hr>
    <div class="row">
        <?php foreach ($work->getImages() as $image): ?>
            <div class="col-lg-2 col-md-3">
                <div class="thumbnail">
                    <img
                        class="img-responsive"
                        src="/image<?= $imageUrlBuilder->getUrl($image->getImageId().'_'.$image->getPath(), ['w' => 500, 'h' => 500, 'fit' => 'crop', 'border' => '10,000']) ?>"
                        alt=""
                    >
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
