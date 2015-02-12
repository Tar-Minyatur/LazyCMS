<?php if (is_array($page->extractorLog)): ?>
    <section id="extractorLog" class="log">
        <h2>Label Extractor</h2>
        <ul>
            <?php foreach ($page->extractorLog as $logEntry): ?>
                <li><?php echo $logEntry; ?></li>
            <?php endforeach; ?>
        </ul>
        <form action="<?php echo $page->formAction; ?>" method="post">
            <input type="hidden" name="action" value="replaceDataFile">
            <textarea name="json" rows="10" cols="120"><?php
                echo htmlspecialchars(json_encode(
                    $page->newFields,
                    defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0));
                ?></textarea>
            <br /><br />
            <button type="submit">Replace Data File</button>
        </form>
    </section>
<?php endif; ?>