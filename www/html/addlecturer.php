<?php

require_once 'includes/authorization-inc.php';
assert_logged_in();

if (!isset($_GET['courseID'])) {
    exit('Wrong parameters');
}

$courseID = $_GET['courseID'];
$new = ($courseID == 'new');

require_once 'includes/courses-inc.php';
if (!is_admin() && !(getUID() == getGuarantorID($courseID))) {
    dieForbidden();
}

addLecturer($courseID, $_GET['lecturerID']);

header("location: ../editcourse.php?courseID=$courseID");
