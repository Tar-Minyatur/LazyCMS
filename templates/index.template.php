<!doctype html>
<html>
    <head>
        <title>Lazy CMS</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/css/screen.css">
    </head>
    <body>
        <header>
            <h1>Lazy CMS</h1>
            <?php if ($page->loggedIn): ?>
            <a href="<?php echo $page->rootDir; ?>">Content Management</a>
            <form action="<?php echo $page->formAction; ?>" method="post">
                <input type="hidden" name="action" value="generateFiles">
                <button type="submit" id="b_regenFiles">Regenerate Files</button>
            </form>
            <form action="<?php echo $page->formAction; ?>" method="post">
                <input type="hidden" name="action" value="extractLabels">
                <button type="submit" id="b_extractLabels">Extract Text Labels</button>
            </form>
            <form action="<?php echo $page->formAction; ?>" method="post">
                <input type="hidden" name="action" value="logout">
                <button type="submit" id="b_logout">Logout</button>
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
                switch ($page->currentPage):
                    case 'content':
                        require('content_management.template.php');
                        break;
                    case 'generator':
                        require('generator_log.template.php');
                        break;
                    case 'extractor':
                        require('label_extractor.template.php');
                        break;
                endswitch;
            else:
                require('login.template.php');
            endif;
        ?>
        <script type="text/javascript" src="assets/js/app.js"></script>
    </body>
</html>