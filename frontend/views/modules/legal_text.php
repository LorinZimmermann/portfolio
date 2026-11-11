<?php
$data = $args['data'];
$render_text = static function (string $text): string {
    return wp_kses_post(wpautop($text));
};
?>

<section data-module="legal_text">
    <article class="column">
        <h2 class="title"><?= esc_html($data['title_1']) ?></h2>
        <div class="text">
            <?= $render_text((string) ($data['text_1'] ?? '')) ?>
        </div>
    </article>
    <article class="column">
        <h2 class="title"><?= esc_html($data['title_2']) ?></h2>
        <div class="text">
            <?= $render_text((string) ($data['text_2'] ?? '')) ?>
        </div>
    </article>
</section>
