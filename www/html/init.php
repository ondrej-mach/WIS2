<?php

require_once 'includes/dbh-inc.php';

$result = $conn->query('SELECT COUNT(*) FROM Admin')->fetchColumn();

require_once 'includes/useradd-inc.php';

if ($result == 0) {
    echo "There are no admins, adding one now...\n";
    userAdd('admin', 'admin');
    userMod(username2uid('admin'), ['is_admin' => true]);
    
} else {
    echo "There are some admins\n";
}


