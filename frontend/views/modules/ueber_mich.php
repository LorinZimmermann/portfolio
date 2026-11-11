<?php
$data = $args['data'];
?>

<section data-module="ueber_mich">
    <div class="image-wrapper">
        <img
            class="image"
            src="<?= $data['image']['src'] ?>"
            alt="<?= $data['image']['alt'] ?>"
        >
    </div>
    <div class="content">
        <h2 class="title"><?= $data['title'] ?></h2>
        <p class="text"><?= nl2br($data['text']) ?></p>
    </div>
</section>
