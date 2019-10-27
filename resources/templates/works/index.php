<?php /** @var \Gks\Domain\Model\Work[] $works */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => 'Portfolio',
]) ?>

<section class="work-overview">
    <?php foreach ($works as $work): ?>
        <article class="work">
            <div class="work__title">
                <h1><?= $work->getTitle()->getValue('en_US') ?></h1>
            </div>
            <?php if (!empty($work->getImages())): ?>
                <img
                        class="work__image"
                        src="/image<?= $imageUrlBuilder->getUrl($work->getImages()[0]->getFilename(), ['w' => 500, 'h' => 500, 'fit' => 'crop']) ?>"
                        alt=""
                >
            <?php endif; ?>
            <div class="work__link">
                <a href="/portfolio/work/<?= $work->getId()->getValue() ?>"></a>
            </div>
        </article>
    <?php endforeach; ?>
</section>
