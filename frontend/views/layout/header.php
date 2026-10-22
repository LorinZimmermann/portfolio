<?php
$menu = get_menu_by_slug(slug:'main');
$first_item = array_shift($menu);
?>

<header data-layout="header">
    <a
        target="<?= $first_item['target'] ?>"
        href="<?= $first_item['url'] ?>"
    >
        <?= $first_item['title'] ?>
    </a>
    <div class="archive-label" aria-label="Aktuelles Datum und aktuelle Uhrzeit">
        <span data-current-date><?= esc_html(wp_date('d.m.Y')) ?></span>
        <span aria-hidden="true"> / </span>
        <span data-current-time><?= esc_html(wp_date('H:i:s')) ?></span>
    </div>
    <nav class="nav-container">
        <ul class="nav">
            <?php foreach ($menu as $item): ?>
            <?php
            $item_page_id = url_to_postid($item['url']);
            $is_active = $item_page_id > 0 && is_page($item_page_id);
            ?>
            <li class="nav-item<?= $is_active ? ' is-active' : '' ?>">
                <a target="<?= esc_attr($item['target']) ?>" href="<?= esc_url($item['url']) ?>">
                    <?= esc_html($item['title']) ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
