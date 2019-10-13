<?php /** @var \Gks\Domain\Model\Work[] $works */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => 'Portfolio',
]) ?>

<section class="work-overview">
    <?php foreach ($works as $work): ?>
        <article class="work-overview__item">
            <?php if (!empty($work->getImages())): ?>
                <img
                        src="/image<?= $imageUrlBuilder->getUrl($work->getImages()[0]->getFilename(), ['w' => 500, 'h' => 500, 'fit' => 'crop']) ?>"
                        alt=""
                >
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>
