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
            <form action="<?php echo $page->formAction; ?>" method="post">
                <input type="hidden" name="action" value="generateFiles">
                <button type="submit">Regenerate Files</button>
            </form>
            <form action="<?php echo $page->formAction; ?>" method="post">
                <input type="hidden" name="action" value="extractLabels">
                <button type="submit">Extract Text Labels</button>
            </form>
            <?php endif; ?>
            <a href="<?php echo $page->homepageURL; ?>" target="_blank">Open Homepage</a>
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
                require('generator_log.template.php');
                require('label_extractor.template.php');
            else:
                require('login.template.php');
            endif;
        ?>
    </body>
</html>