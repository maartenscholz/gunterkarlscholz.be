<?php /** @var \Gks\Domain\Model\Work $work */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => $work->getTitle()->getValue('en_US') . ' | Portfolio',
]) ?>

<section class="work-detail">
    <h1><?= $work->getTitle()->getValue('en_US') ?></h1>
</section>
