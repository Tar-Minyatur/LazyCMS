<?php
if (!defined('IN_LAZY_CMS')) {
    die('Security violation.');
}
?>
<!doctype html>
<html>
    <head>
        <title>Lazy CMS</title>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1>Lazy CMS</h1>
            <?php if ($page->loggedIn): ?>
            <form action="<?php echo $page->formAction; ?>" method="post">
                <input type="hidden" name="action" value="logout">
                <button type="submit">Logout</button>
            </form>
            <?php endif; ?>
        </header>
        <?php if (!is_null($page->error)): ?>
        <div class="error">
            <?php echo $page->error; ?>
        </div>
        <?php endif; ?>
        <?php if (!is_null($page->confirmation)): ?>
        <div class="confirmation">
            <?php echo $page->confirmation; ?>
        </div>
        <?php endif; ?>
        <?php if ($page->loggedIn): ?>
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
                        <textarea cols="60" rows="2" name="fields[<?php echo htmlspecialchars($key); ?>]" id="field_<?php echo $index; ?>"><?php echo htmlspecialchars($value); ?></textarea>
                        <br />
                    <?php $index++; ?>
                    <?php endforeach; ?>
                    <br /><br />
                    <button type="submit">Save Changes</button>
                </fieldset>
            </form>
        </section>
        <?php else: ?>
        <section id="login">
            <h2>Login</h2>
            <form action="<?php echo $page->loggedIn; ?>" method="post">
                <input type="hidden" name="action" value="login">
                <fieldset>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                    <br />
                    <button type="submit">Login</button>
                </fieldset>
            </form>
        </section>
        <?php endif; ?>
    </body>
</html>