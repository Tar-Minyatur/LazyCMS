<section id="content">
    <h2>Content Management</h2>
    <form action="<?php echo $page->formAction; ?>" method="post">
        <input type="hidden" name="action" value="updateData">
        <fieldset>
            <ol>
                <?php $index = 1; ?>
                <?php foreach ($page->fields as $key => $value): ?>
                    <?php if (is_array($value)): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($key); ?></strong>
                            <ol>
                            <?php foreach ($value as $subkey => $subvalue): ?>
                                <li>
                                    <label for="field_<?php echo $index; ?>">
                                        <?php echo htmlspecialchars($subkey); ?>:
                                    </label>
                                    <textarea cols="60"
                                              rows="2"
                                              name="fields[<?php echo htmlspecialchars($key); ?>][<?php echo htmlspecialchars($subkey); ?>]"
                                              id="field_<?php echo $index; ?>"><?php echo htmlspecialchars($subvalue); ?></textarea>
                                </li>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                            </ol>
                        </li>
                    <?php else: ?>
                        <li>
                            <label for="field_<?php echo $index; ?>">
                                <?php echo htmlspecialchars($key); ?>:
                            </label>
                            <textarea cols="60"
                                      rows="2"
                                      name="fields[<?php echo htmlspecialchars($key); ?>]"
                                      id="field_<?php echo $index; ?>"><?php echo htmlspecialchars($value); ?></textarea>
                        </li>
                    <?php endif; ?>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </ol>
            <br /><br />
            <button type="submit">Save Changes</button>
        </fieldset>
    </form>
</section>