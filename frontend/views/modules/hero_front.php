<?php
$data = $args['data'];
$title_letters = mb_str_split($data['title']);
$photography_images = [];
$photography_page = get_page_by_path('fotografie');

if ($photography_page) {
    $photography_modules = carbon_get_post_meta($photography_page->ID, 'modules');
    foreach ((array) $photography_modules as $module) {
        if (($module['_type'] ?? '') !== 'photography_project') {
            continue;
        }

        foreach ((array) ($module['images'] ?? []) as $image_id) {
            $image = get_media_by_id($image_id, 'large');
            if ($image && !empty($image['src'])) {
                $photography_images[] = $image;
            }
        }
    }
}

$photography_images = array_values(array_unique($photography_images, SORT_REGULAR));
?>

<section data-module="hero_front">
    <?php if ($photography_images): ?>
        <div class="hero-photos" aria-hidden="true">
            <?php foreach ($photography_images as $image): ?>
                <img class="hero-photo" data-hero-photo src="<?= esc_url($image['src']) ?>" alt="" loading="eager">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h1 class="title">
        <?php foreach ($title_letters as $letter): ?>
            <span class="letter<?= trim($letter) === '' ? ' space' : (trim($letter) === '.' ? ' punctuation' : '') ?>"><?= $letter ?></span>
        <?php endforeach; ?>
    </h1>
    <?php if ($data['subline']):?>
        <p class="subline"><?= $data['subline'] ?></p>
    <?php endif; ?>
</section>
