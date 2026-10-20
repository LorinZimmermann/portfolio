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
    <nav class="nav-container">
        <ul class="nav">
            <?php foreach ($menu as $item): ?>
                <?php
                $item_slug = sanitize_title($item['title']);
                $page_links = [
                    'video' => '/video/',
                    'audio' => '/audio/',
                    'fotografie' => '/fotografie/',
                ];
                $item_url = array_key_exists($item_slug, $page_links)
                    ? home_url($page_links[$item_slug])
                    : $item['url'];
                $is_active = array_key_exists($item_slug, $page_links) && is_page($item_slug);
                ?>
                <li class="nav-item<?= $is_active ? ' is-active' : '' ?>">
                    <a target="<?= $item['target'] ?>" href="<?= $item_url ?>">
                        <?=$item['title']?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
