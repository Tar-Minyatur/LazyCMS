<?php $this->layout('cms::template', array('pageTitle' => 'Content Management')) ?>

<section id="content">
    <h2>Content Management</h2>
    <form action="<?php echo $formAction ?>" method="post">
        <input type="hidden" name="action" value="updateData">
        <fieldset>
            <ol>
                <?php $index = 1 ?>
                <?php foreach ($fields as $key => $value): ?>
                    <?php if (is_array($value)): ?>
                        <li>
                            <strong><?php echo $this->e($key) ?></strong>
                            <ol>
                            <?php foreach ($value as $subkey => $subvalue): ?>
                                <li>
                                    <label for="field_<?php echo $index ?>">
                                        <?php echo $this->e($subkey); ?>:
                                    </label>
                                    <br />
                                    <textarea cols="60"
                                              rows="2"
                                              name="fields[<?php echo $this->e($key) ?>][<?php echo $this->e($subkey) ?>]"
                                              id="field_<?php echo $index ?>"><?php echo $this->e($subvalue) ?></textarea>
                                </li>
                            <?php $index++ ?>
                        <?php endforeach ?>
                            </ol>
                        </li>
                    <?php else: ?>
                        <li>
                            <label for="field_<?php echo $index ?>">
                                <?php echo $this->e($key) ?>:
                            </label>
                            <br />
                            <textarea cols="60"
                                      rows="2"
                                      name="fields[<?php echo $this->e($key) ?>]"
                                      id="field_<?php echo $index ?>"><?php echo $this->e($value) ?></textarea>
                        </li>
                    <?php endif ?>
                    <?php $index++ ?>
                <?php endforeach ?>
            </ol>
            <br /><br />
            <button type="submit">Save Changes</button>
        </fieldset>
    </form>
</section>