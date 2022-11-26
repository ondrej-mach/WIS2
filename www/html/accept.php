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
    try{
        if ($value == "on") {
            setApproval($courseID, $key, 1);
        } 
        else if ($value == "off"){
            setApproval($courseID, $key, 0);
        }
    } catch (Exception $e) {
        header("location: acceptstudents.php?courseID=$courseID&error=1");
        exit;
    }
}

header("location: acceptstudents.php?courseID=$courseID&success=1");
?>
