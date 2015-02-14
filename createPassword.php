<?php
require 'vendor/autoload.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>LazyCMS - Password Converter</title>
    </head>
    <body>
        <h1>LazyCMS</h1>
        <h2>Password Converter</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="password">Password:</label><br />
            <input type="password" name="password" id="password"><br />
            <label for="password2">Repeat Password:</label><br />
            <input type="password" name="password2" id="password2"><br />
            <br />
            <button type="submit">Convert Into Secure Hash</button>
        </form>
        <?php if (isset($_POST['password']) && isset($_POST['password2'])): ?>
            <h3>Result</h3>
            <?php if (strlen($_POST['password']) < 1): ?>
                <p><strong>Xou need to enter a password!</strong></p>
            <?php elseif ($_POST['password'] !== $_POST['password2']): ?>
                <p><strong>You entered two different passwords. Try again.</strong></p>
            <?php else: ?>
                <p>
                    <strong>Password Hash:</strong>
                    <?php $passwordUtil = new \LazyCMS\PasswordUtil(); ?>
                    <?php $hash = $passwordUtil->hashPassword($_POST['password']) ?>
                    <input type="text" value="<?php echo htmlentities($hash) ?>" />
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>