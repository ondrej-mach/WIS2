<?php

require_once 'includes/authorization-inc.php';
assert_logged_in();

if (!isset($_GET['points']) || !isset($_GET['termID']) || !isset($_GET['courseID'])) {
    exit('Wrong parameters');
}

require_once 'includes/courses-inc.php';
require_once 'includes/student-inc.php';

$courseID = $_GET['courseID'];

$termID = $_GET['termID'];
$points = $_GET['points'];
$uid = getUID();

$lecturers = getLecturerIDs($courseID);

if (!(is_teacher() && (in_array($uid, $lecturers) || $uid == getGuarantorID($courseID)))) {
    dieForbidden();
}

foreach($points as $key => $value) {
    if (!isset($value)) {
        evaluateTerm($termID, $key, $uid, $value);
    }
    else {
        updatePoints($value, $uid, $termID, $key);
    }
}

header("location: evaluateterm.php?termID=$termID");
?>