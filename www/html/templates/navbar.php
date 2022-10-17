<h1>WIS 2</h1>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/authorization-inc.php';
    
    if (is_admin()) {
        # TODO
        echo "<a href=manageusers.php>User management</a>";
        echo "<a href=managerooms.php>Room management</a>";
    }
    
    if (!is_admin() && is_logged_in()) {
        # TODO
        echo "My Account\n";
    }
    
    if (is_admin()) {
        echo "<a href=admincourses.php>Manage courses</a>";
    }
    
    if (is_teacher()) {
        echo "<a href=teachercourses.php>Organize courses</a>";
    }
    
    if (is_student()) {
        echo "<a href=studentcourses.php>My courses</a>";
    }
    
    if (is_logged_in()) {
        $username = $GLOBALS['user']->accountUsername;
        echo $username;
        echo "<a href='logout.php'>Log out</a>\n";
    } else {
        echo "<a href='login.php'>Log in</a>\n";
    }
    
?>

<br/>
