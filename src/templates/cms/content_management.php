<?php $this->layout('cms::template', array('pageTitle' => 'Content Management')) ?>

<section id="content">
    <h2>Content Management</h2>
    <?php if (is_array($dataFiles)): ?>
        <form action="<?php echo $formAction ?>" method="post">
            <input type="hidden" name="action" value="updateData">
            <fieldset>
                <ol>
                    <?php $fileIndex = 0 ?>
                    <?php $fieldIndex = 0 ?>
                    <?php foreach ($dataFiles as $file => $fields): ?>
                        <li>
                            <strong><?php echo $this->e($file) ?></strong>
                            <ol>
                            <?php foreach ($fields as $field => $value): ?>
                                <li>
                                    <label for="field_<?php echo $fieldIndex ?>">
                                        <?php echo $this->e($field); ?>:
                                    </label>
                                    <br />
                                    <textarea cols="60"
                                              rows="2"
                                              name="fields[<?php echo $fileIndex ?>][<?php echo $this->e($field) ?>]"
                                              id="field_<?php echo $fieldIndex ?>"><?php echo $this->e($value) ?></textarea>
                                    <input type="hidden" name="files[<?php echo $fileIndex ?>]" value="<?php echo $this->e($file) ?>">
                                </li>
                                <?php $fieldIndex++ ?>
                            <?php endforeach ?>
                            </ol>
                        </li>
                        <?php $fileIndex++ ?>
                    <?php endforeach ?>
                </ol>
                <button type="submit">Save Changes</button>
            </fieldset>
        </form>
    <?php endif ?>
</section>
