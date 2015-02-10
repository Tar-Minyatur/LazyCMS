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
        
        <?php
            if ($page->loggedIn):
                require('content_management.template.php');
            else:
                require('login.template.php');
            endif;
        ?>
    </body>
</html>