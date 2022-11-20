<?php

require_once 'includes/authorization-inc.php';
assert_logged_in();

if (!isset($_GET['courseID']) || !isset($_GET['approved'])) {
    exit('Wrong parameters');
}

require_once 'includes/courses-inc.php';
require_once 'includes/student-inc.php';
require_once 'includes/terms-inc.php';

$courseID = $_GET['courseID'];
$approved = $_GET['approved'];
$uid = getUID();
if (!(is_teacher() && ($uid == getGuarantorID($courseID)))) {
    dieForbidden();
}

foreach($approved as $key => $value) {
    if ($value == "on") {
        setRegistration($courseID, $key, 1);
    } 
    else if ($value == "off"){
        setRegistration($courseID, $key, 0);
    }
}

header("location: acceptstudents.php?courseID=$courseID");
?>