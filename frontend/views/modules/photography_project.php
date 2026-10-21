<?php
$data = $args['data'];
$images = $data['images'] ?? [];
?>

<section data-module="photography_project">
    <header class="project-header">
        <h2 class="title"><?= esc_html($data['title']) ?></h2>
        <div class="project-info">
            <?php if (!empty($data['year']) || !empty($data['type'])): ?>
                <p class="meta archive-meta"><?= esc_html($data['year'] ?? '') ?> / <?= esc_html($data['type'] ?? '') ?></p>
            <?php endif; ?>
            <?php if (!empty($data['description'])): ?>
                <p class="description"><?= nl2br(esc_html($data['description'])) ?></p>
            <?php endif; ?>
            <button class="shuffle-button" type="button" data-photo-shuffle>
                [DURCHMISCHEN]
            </button>
        </div>
    </header>

    <?php if ($images): ?>
        <div class="photo-collage" data-photo-collage>
            <?php foreach ($images as $image): ?>
                <figure class="photo" data-photo-item>
                    <img src="<?= esc_url($image['src']) ?>" alt="<?= esc_attr($image['alt']) ?>" loading="lazy">
                </figure>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
