<?php /** @var \Gks\Application\DTOs\WorkDTO[] $works */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => 'Portfolio',
]) ?>

<section class="work-overview">
    <?php foreach ($works as $work): ?>
        <?php if (!empty($work->images)): ?>
            <article class="work">
                <div class="work__content">
                    <div class="work__title">
                        <h1><?= $work->title->nl ?></h1>
                    </div>
                </div>
                    <img
                            class="work__image"
                            src="/image<?= $imageUrlBuilder->getUrl($work->images[0]->filename, ['w' => 500, 'h' => 500, 'fit' => 'crop-50-50-1.1']) ?>"
                            alt=""
                    >
                <div class="work__link">
                    <a href="/works/<?= $work->slug ?>"></a>
                </div>
                <div class="work__overlay"></div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
