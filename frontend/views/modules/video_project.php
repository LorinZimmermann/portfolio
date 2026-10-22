<?php
$data = $args['data'];
$video_url = isset($data['video']) ? esc_url_raw($data['video']) : '';
$video_embed = $video_url ? wp_oembed_get($video_url) : false;

if (!$video_embed && $video_url) {
    $youtube_id = '';
    $youtube_host = wp_parse_url($video_url, PHP_URL_HOST);
    $youtube_path = wp_parse_url($video_url, PHP_URL_PATH);

    if (in_array($youtube_host, ['youtu.be', 'www.youtu.be'], true)) {
        $youtube_id = trim($youtube_path, '/');
    } elseif (in_array($youtube_host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
        if ($youtube_path === '/watch') {
            parse_str((string) wp_parse_url($video_url, PHP_URL_QUERY), $youtube_query);
            $youtube_id = $youtube_query['v'] ?? '';
        } elseif (str_starts_with((string) $youtube_path, '/shorts/')) {
            $youtube_id = trim(substr($youtube_path, 8), '/');
        } elseif (str_starts_with((string) $youtube_path, '/embed/')) {
            $youtube_id = trim(substr($youtube_path, 7), '/');
        }
    }

    if ($youtube_id && preg_match('/^[A-Za-z0-9_-]{11}$/', $youtube_id)) {
        $video_embed = '<iframe src="' . esc_url('https://www.youtube-nocookie.com/embed/' . $youtube_id)
            . '" title="' . esc_attr($data['title'])
            . '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
    }
}
?>

<section data-module="video_project">
    <header class="project-header">
        <h2 class="title"><?= esc_html($data['title']) ?></h2>
        <?php if (!empty($data['year']) || !empty($data['type']) || !empty($data['description']) || !empty($data['role'])): ?>
            <div class="project-info">
                <?php if (!empty($data['year']) || !empty($data['type'])): ?>
                    <p class="meta archive-meta"><?= esc_html($data['year'] ?? '') ?> / <?= esc_html($data['type'] ?? '') ?></p>
                <?php endif; ?>
                <?php if (!empty($data['description'])): ?>
                    <p class="description"><?= nl2br(esc_html($data['description'])) ?></p>
                <?php endif; ?>
                <?php if (!empty($data['role'])): ?>
                    <p class="role archive-meta"><strong>ROLLE - </strong><?= esc_html($data['role']) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if ($video_embed): ?>
        <div class="video-wrapper">
            <?= $video_embed ?>
        </div>
    <?php endif; ?>

</section>
