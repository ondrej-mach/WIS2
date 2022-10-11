<?php include_once 'templates/header.php' ?>

<section>
    <h2>Log in</h2>
    
    <?php if (isset($_GET["error"])) echo "<p>Bad credentials</p>"; ?>
    
    <form action="includes/login-inc.php" method="POST">
        <input type="text" name="username" />
        <input type="password" name="password" />
        <button type="submit" name="submit">Log in</button>
    </form>
    
</section>

<?php include_once 'templates/footer.php' ?>
