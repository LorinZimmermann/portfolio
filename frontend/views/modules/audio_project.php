<?php
$data = $args['data'];
$audio_url = $data['audio'] ?? '';
$audio_type = $audio_url ? (wp_check_filetype($audio_url)['type'] ?? '') : '';
?>

<section data-module="audio_project">
    <header class="project-header">
        <h2 class="title"><?= esc_html($data['title']) ?></h2>
        <?php if (!empty($data['year']) || !empty($data['type']) || !empty($data['description'])): ?>
            <div class="project-info">
                <?php if (!empty($data['year']) || !empty($data['type'])): ?>
                    <p class="meta archive-meta"><?= esc_html($data['year'] ?? '') ?> / <?= esc_html($data['type'] ?? '') ?></p>
                <?php endif; ?>
                <?php if (!empty($data['description'])): ?>
                    <p class="description"><?= nl2br(esc_html($data['description'])) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if ($audio_url): ?>
        <div class="audio-player" data-audio-player>
            <audio src="<?= esc_url($audio_url) ?>" type="<?= esc_attr($audio_type) ?>" preload="metadata"></audio>
            <button class="audio-toggle" type="button" data-audio-toggle aria-label="Audio abspielen">
                [ABSPIELEN]
            </button>
            <div class="audio-progress" data-audio-progress>
                <span class="audio-time audio-time-current" data-audio-current>0:00</span>
                <button class="audio-track" type="button" data-audio-seek aria-label="Audio-Position auswählen">
                    <span class="audio-track-fill" data-audio-fill></span>
                    <span class="audio-track-thumb" data-audio-thumb></span>
                </button>
                <span class="audio-time audio-time-total" data-audio-duration>0:00</span>
            </div>
        </div>
    <?php endif; ?>
</section>
