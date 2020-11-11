<?php /** @var \Gks\Application\DTOs\WorkDTO $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => $work->title->nl . ' | Portfolio',
]) ?>

<section class="work-detail">
    <h1 class="work-detail__title"><?= $work->title->nl ?></h1>
    <div class="work-detail__translations">
        <?= $work->title->en ?> /
        <?= $work->title->fr ?> /
        <?= $work->title->de ?>
    </div>
    <div class="work-detail__image">
        <img src="/image<?= $imageUrlBuilder->getUrl($work->images[0]->filename) ?>" alt="">
    </div>
</section>
