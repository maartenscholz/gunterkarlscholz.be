<?php /** @var \Gks\Domain\Model\Work $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => $work->getTitle()->getValue('en_US') . ' | Portfolio',
]) ?>

<section class="work-detail">
    <h1 class="work-detail__title"><?= $work->getTitle()->getValue('en_US') ?></h1>
    <div class="work-detail__translations">
        <?= $work->getTitle()->getValue('nl_BE') ?> /
        <?= $work->getTitle()->getValue('fr_FR') ?> /
        <?= $work->getTitle()->getValue('de_DE') ?>
    </div>
    <div class="work-detail__image">
        <img src="/image<?= $imageUrlBuilder->getUrl($work->getImages()[0]->getFilename()) ?>" alt="">
    </div>
</section>
