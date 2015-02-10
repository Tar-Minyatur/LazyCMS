<section id="content">
    <h2>Content Management</h2>
    <form action="<?php echo $page->formAction; ?>" method="post">
        <input type="hidden" name="action" value="updateData">
        <fieldset>
            <?php $index = 1; ?>
            <?php foreach ($page->fields as $key => $value): ?>
                <label for="field_<?php echo $index; ?>">
                    <?php echo htmlspecialchars($key); ?>:
                </label>
                <textarea cols="60"
                          rows="2"
                          name="fields[<?php echo htmlspecialchars($key); ?>]"
                          id="field_<?php echo $index; ?>"><?php echo htmlspecialchars($value); ?></textarea>
                <br />
                <?php $index++; ?>
            <?php endforeach; ?>
            <br /><br />
            <button type="submit">Save Changes</button>
        </fieldset>
    </form>
</section>