<!doctype html>
<html>
    <head>
        <title>Lazy CMS - <?php echo $this->e($pageTitle) ?></title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    </head>
    <body>
        <header>
            <h1>Lazy CMS</h1>
            <?php if ($loggedIn): ?>
            <a href="<?php echo $rootDir ?>">Content Management</a>
            <form action="<?php echo $formAction ?>" method="post">
                <input type="hidden" name="action" value="generateFiles">
                <button type="submit" id="b_regenFiles">Regenerate Files</button>
            </form>
            <form action="<?php echo $formAction ?>" method="post">
                <input type="hidden" name="action" value="extractLabels">
                <button type="submit" id="b_extractLabels">Extract Text Labels</button>
            </form>
            <form action="<?php echo $formAction ?>" method="post">
                <input type="hidden" name="action" value="logout">
                <button type="submit" id="b_logout">Logout</button>
            </form>
            <?php endif; ?>                        
            <a href="<?php echo $homepageURL ?>" target="_blank">Open Homepage</a>
        </header>
        <?php if (!is_null($error)): ?>
        <div class="error">
            <?php echo $error ?>
        </div>
        <?php endif ?>
        <?php if (!is_null($confirmation)): ?>
        <div class="confirmation">
            <?php echo $confirmation; ?>
        </div>
        <?php endif ?>
        
        <?php echo $this->section('content') ?>
        <script type="text/javascript" src="assets/js/LazyCMS.js"></script>
    </body>
</html>