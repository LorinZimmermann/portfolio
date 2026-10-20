<?php
$data = $args['data'];
js_log($data);
$title_letters = mb_str_split($data['title']);
?>

<section data-module="hero_front">
    <h1 class="title">
        <?php foreach ($title_letters as $letter): ?>
            <span class="letter<?= trim($letter) === '' ? ' space' : '' ?>"><?= $letter ?></span>
        <?php endforeach; ?>
    </h1>
    <?php if ($data['subline']):?>
        <p class="subline"><?= $data['subline'] ?></p>
    <?php endif; ?>
</section>

<script>
(function() {
    const fonts = ['Avenir Next', 'Gill Sans', 'Optima', 'Futura', 'Century Gothic', 'Trebuchet MS'];
    const letters = document.querySelectorAll('[data-module="hero_front"] .letter');
    
    letters.forEach(letter => {
        function changeFont() {
            const randomFont = fonts[Math.floor(Math.random() * fonts.length)];
            letter.style.fontFamily = `${randomFont}, sans-serif`;
        }
        
        changeFont();
        const randomInterval = 1500 + Math.random() * 1500;
        setInterval(changeFont, randomInterval);
    });
})();
</script>
