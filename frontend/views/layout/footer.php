<?php
$menu = get_menu_by_slug(slug:'legals');
$archive_counts = get_archive_media_counts();
?>

<footer data-layout="footer">
    <div class="archive-status">
        <?= esc_html((string) $archive_counts['photos']) ?> FOTOGRAFIEN /
        <?= esc_html((string) $archive_counts['videos']) ?> VIDEOS /
        <?= esc_html((string) $archive_counts['audio']) ?> AUDIOAUFNAHMEN
    </div>
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
                            <a target="<?= esc_attr($item['target']) ?>" href="<?= esc_url($item['url']) ?>">
                                <?= esc_html($item['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <span>© 2026 LORIN ZIMMERMANN</span>
        </div>
    </div>
</footer>
