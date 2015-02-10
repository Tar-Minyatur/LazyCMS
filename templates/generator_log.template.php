<?php if (is_array($page->generatorLog)): ?>
    <section id="generatorLog">
        <h2>File Generator</h2>
        <ul>
            <?php foreach ($page->generatorLog as $logEntry): ?>
                <li><?php echo $logEntry; ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>