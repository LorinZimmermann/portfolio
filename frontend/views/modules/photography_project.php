<?php
$data = $args['data'];
$images = $data['images'] ?? [];
?>

<section data-module="photography_project">
    <header class="project-header">
        <h2 class="title"><?= esc_html($data['title']) ?></h2>
        <button class="shuffle-button" type="button" data-photo-shuffle>
            [DURCHMISCHEN]
        </button>
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
