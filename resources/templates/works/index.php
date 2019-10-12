<?php /** @var \Gks\Domain\Model\Work[] $works */ ?>
<?php /** @var \League\Glide\Urls\UrlBuilder $imageUrlBuilder */ ?>

<?php $this->layout('app', [
    'title' => 'Portfolio',
]) ?>

<ul class="work-overview">
    <?php foreach ($works as $work): ?>
        <li>
            <?php if (!empty($work->getImages())): ?>
                <img
                        src="/image<?= $imageUrlBuilder->getUrl($work->getImages()[0]->getFilename(), ['w' => 500, 'h' => 500, 'fit' => 'crop']) ?>"
                        alt=""
                >
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
