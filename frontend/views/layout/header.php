<?php
$menu = get_menu_by_slug(slug:'main');
$first_item = array_shift($menu);
?>

<header data-layout="header">
    <a target="<?= $first_item['target'] ?>" href="<?= $first_item['url'] ?>">
        <?= $first_item['title'] ?>
    </a>
    <nav class="nav-container">
        <ul class="nav">
            <?php foreach ($menu as $item): ?>
                <li class="nav-item">
                    <a target="<?= $item['target'] ?>"href="<?=$item['url']?>">
                        <?=$item['title']?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
