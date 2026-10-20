<?php
$menu = get_menu_by_slug(slug:'legals');
?>

<footer data-layout="footer">
    <div class="footer-content">
        <div class="footer-left">
            <span>KONTAKT</span>
            <span>lorin.zimmermann@gmx.ch</span>
        </div>
        <div class="footer-right">
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
            <span>© 2026 LORIN ZIMMERMANN</span>
        </div>
    </div>
</footer>
