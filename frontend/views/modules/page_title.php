<?php
$data = $args['data'];
$menu = get_menu_by_slug(slug: 'main');
$home_item = $menu[0] ?? null;
$current_item = null;

foreach ($menu as $item) {
    if (url_to_postid($item['url']) === get_the_ID()) {
        $current_item = $item;
        break;
    }
}

$home_title = $home_item['title'] ?? '';
$current_title = $current_item['title'] ?? get_the_title();
$breadcrumb = array_filter(
    $current_title === $home_title ? [$home_title] : [$home_title, $current_title]
);
$breadcrumb = array_map(
    static fn (string $item): string => trim($item, "[] \t\n\r\0\x0B"),
    $breadcrumb
);
?>

<section data-module="page_title">
    <div class="breadcrumb"><?= esc_html(implode(' / ', $breadcrumb)) ?></div>
    <h1 class="title"><?= esc_html($data['title']) ?></h1>
</section>
