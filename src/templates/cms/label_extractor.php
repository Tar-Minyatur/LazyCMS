<?php $this->layout('cms::template', array('pageTitle' => 'Extract Text Labels')) ?>

<section id="extractorLog" class="log">
    <h2>Label Extractor</h2>
    <ul>
        <?php foreach ($extractorLog as $logEntry): ?>
            <li><?php echo $this->e($logEntry) ?></li>
        <?php endforeach; ?>
    </ul>
    <p>This is the resulting data file. If this is correct, you can save it using the button below:</p>
    <form action="<?php echo $formAction ?>" method="post">
        <input type="hidden" name="action" value="replaceDataFile">
        <textarea name="json" rows="20" cols="120" readonly><?php
            echo htmlspecialchars(json_encode(
                $newFields,
                defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 0))
            ?></textarea>
        <br /><br />
        <button type="submit">Replace Data File</button>
    </form>
</section>