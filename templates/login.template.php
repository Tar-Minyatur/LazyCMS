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