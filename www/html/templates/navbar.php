<h1>WIS 2</h1>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/authorization-inc.php';
    
    if (is_admin()) {
        # TODO
        echo "<a href=manageusers.php>User management</a>";
    }
    if (is_logged_in()) {
        # TODO
        echo "change account\n";
    }
    
    
    
    
    if (is_logged_in()) {
        # TODO
        echo "<a href='/logout.php'>log out</a>\n";
    } else {
        echo "<a href='/login.php'>log in</a>\n";
    }
    
?>

<br/>
