<?php require_once 'includes/authorization-inc.php'; ?>

<!DOCTYPE html>
<html>
<?php include_once 'templates/header.php'; ?>
<?php include_once 'templates/navbar.php'; ?>

<div id="button_back"></div><br/>
</section>

<section id="section_index">
<ul>

<?php

if (!is_logged_in()) {
    echo "<a href=login.php><li>Login</li></a>";
}

if (!is_admin() && is_logged_in()) {
    echo "<a href=usermod.php><li>Manage account</li></a>";
}

if (is_student()) {
    echo "<a href=studentcourses.php><li>Courses</li></a>";
}

if (is_teacher()) {
    echo "<a href=teachercourses.php><li>Manage courses</li></a>";
}

if (is_admin()) {
    echo "<a href=manageusers.php><li>User management</li></a>";
    echo "<a href=managerooms.php><li>Room management</li></a>";
    echo "<a href=admincourses.php><li>Manage courses</li></a>";
}

if (is_logged_in() && !is_admin() && !is_teacher() && !is_student()) {
    dieForbidden();
}
?>
</ul>
<?php include_once 'templates/footer.php'; ?>

</html>