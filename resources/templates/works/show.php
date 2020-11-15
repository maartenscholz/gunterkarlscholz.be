<?php /** @var \Gks\Application\DTOs\WorkDTO $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => $work->title->nl . ' | Portfolio',
]) ?>

<section class="work-detail<?= $work->description ? '' : ' work-detail--no-description' ?>">
    <h1 class="work-detail__title"><?= $work->title->nl ?></h1>
    <div class="work-detail__translations">
        <?= $work->title->en ?> /
        <?= $work->title->fr ?> /
        <?= $work->title->de ?>
    </div>
    <?php if ($work->description): ?>
        <div class="work-detail__description">
            <?= nl2br($this->escape($work->description)) ?>
        </div>
    <?php endif; ?>
    <div class="work-detail__image">
        <img src="/image<?= $imageUrlBuilder->getUrl($work->images[0]->filename) ?>" alt="">
    </div>
</section>
