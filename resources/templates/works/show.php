<?php /** @var \Gks\Domain\Model\Work $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => $work->getTitle()->getValue('en_US') . ' | Portfolio',
]) ?>

<section class="work-detail">
    <h1 class="work-detail__title"><?= $work->getTitle()->getValue('en_US') ?></h1>
    <h2 class="work-detail__subtitle">
        <?= $work->getTitle()->getValue('nl_BE') ?> /
        <?= $work->getTitle()->getValue('fr_FR') ?> /
        <?= $work->getTitle()->getValue('de_DE') ?>
    </h2>
    <div class="work-detail__image">
        <img src="/image<?= $imageUrlBuilder->getUrl($work->getImages()[0]->getFilename()) ?>" alt="">
    </div>
</section>
