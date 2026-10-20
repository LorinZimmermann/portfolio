<?php
$data = $args['data'];
js_log($data);
$title_letters = mb_str_split($data['title']);
?>

<section data-module="hero_front">
    <h1 class="title">
        <?php foreach ($title_letters as $letter): ?>
            <span class="letter"><?= $letter ?></span>
        <?php endforeach; ?>
    </h1>
    <?php if ($data['subline']):?>
        <p class="subline"><?= $data['subline'] ?></p>
    <?php endif; ?>
</section>

<script>
(function() {
    const fonts = ['Arial', 'Helvetica', 'Times New Roman', 'Georgia', 'Verdana', 'Courier New', 'Impact'];
    const letters = document.querySelectorAll('[data-module="hero_front"] .letter');
    
    letters.forEach(letter => {
        function changeFont() {
            const randomFont = fonts[Math.floor(Math.random() * fonts.length)];
            letter.style.fontFamily = randomFont;
        }
        
        changeFont();
        const randomInterval = 500 + Math.random() * 1000;
        setInterval(changeFont, randomInterval);
    });
})();
</script>
