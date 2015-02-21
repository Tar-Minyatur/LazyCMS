<?php $this->layout('cms::template', array('pageTitle' => 'Extract Text Labels')) ?>

<section id="extractorLog" class="log">
    <h2>Label Extractor</h2>
    <ul>
        <?php foreach ($extractorLog as $logEntry): ?>
            <li><?php echo $this->e($logEntry) ?></li>
        <?php endforeach ?>
    </ul>
    <p>These are the resulting data files. If everything is correct, you can save them using the button below:</p>
    <form action="<?php echo $formAction ?>" method="post">
        <input type="hidden" name="action" value="replaceDataFile">
        <fieldset>
            <ol>
                <?php $fileCounter = 0 ?>
                <?php foreach ($newFields as $file => $json): ?>
                    <li>
                        <label for="json_<?php echo $fileCounter ?>">
                            <?php echo $this->e($file) ?>
                        </label>
                        <br>
                        <textarea name="jsons[<?php echo $fileCounter ?>]"
                                  id="json_<?php echo $fileCounter ?>"
                                  rows="10"
                                  cols="120"
                                  readonly><?php echo $this->e($json) ?></textarea>
                        <input type="hidden" name="files[<?php echo $fileCounter; ?>]" value="<?php echo $this->e($file); ?>">
                    </li>
                    <?php $fileCounter++ ?>
                <?php endforeach ?>
            </ol>
        </fieldset>
        <button type="submit">Replace Data Files</button>
    </form>
</section>