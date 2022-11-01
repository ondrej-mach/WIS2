<?php include_once 'templates/header.php' ?>
<ul>
    <li>
        <a href=index.php id="logo">
            <img src="../res/vut_logo.png" alt="VUT logo">
            <h1>WIS 2</h1>
        </a>
    </li>
    <li id="filler">
</ul>
<section id="section_login">
    <h2>Login</h2>

    <?php if (isset($_GET["error"])) echo "<p>Bad credentials</p>"; ?>

    <form id="login_form" action="includes/login-inc.php" method="POST">
        <input class="input_login" type="text" name="username" />
        <input class="input_login" type="password" name="password" />
        <button id="submit_button" type="submit" name="submit">Log in</button>
    </form>

</section>

<?php include_once 'templates/footer.php' ?>
