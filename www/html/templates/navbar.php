<section class="section_navbar">

<?php
    require_once 'includes/authorization-inc.php';
    echo "<ul>
            <li>
                <a href=index.php id=\"logo\">
                    <img src=\"res/vut_logo.png\" alt=\"VUT logo\">
                    <h1>WIS 2</h1>
                </a>
            </li>";  

    if (is_admin()) {
        # TODO
        echo "<li><a href=manageusers.php>User management</a></li>";
        echo "<li><a href=managerooms.php>Room management</a></li>";
        echo "<li><a href=admincourses.php>Manage courses</a></li>";
    }
    
    if (!is_admin() && is_logged_in()) {
        echo "<li><a href=usermod.php>My Account</a></li>";
    }
    
    if (is_teacher()) {
        echo "<li><a href=teachercourses.php>Organize courses</a></li>";
    }
    
    if (is_student()) {
        echo "<li><a href=studentcourses.php>My courses</a></li>";
    }
    
    echo "<li id=\"filler\">";

    if (is_logged_in()) {
        echo "<li><a href='logout.php'>Log out</a></li>\n";
    } else {
        echo "<li><a href='login.php'>Log in</a></li>\n";
    }

    echo "</ul>
        </section>
        <section id=\"back_login\">";
    
    if (is_logged_in()) {
        $username = $GLOBALS['user']->accountUsername;
        echo "<div id=\"uname_div\"><p id=\"username\">Logged in as $username</p></div>";
    }
    else {
        echo "<div id=\"uname_div\"><p id=\"username\">Not logged in</p></div>";
    }
?>
