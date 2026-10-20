<?php
$data = $args['data'];
$video_embed = wp_oembed_get($data['video']);
?>

<section data-module="video_project">
    <header class="project-header">
        <h2 class="title"><?= esc_html($data['title']) ?></h2>
        <div class="project-info">
            <p class="meta"><?= esc_html($data['year']) ?> / <?= esc_html($data['type']) ?></p>
            <p class="description"><?= nl2br(esc_html($data['description'])) ?></p>
            <p class="role"><strong>ROLLE - </strong><?= esc_html($data['role']) ?></p>
        </div>
    </header>

    <?php if ($video_embed): ?>
        <div class="video-wrapper">
            <?= $video_embed ?>
        </div>
    <?php endif; ?>

</section>
