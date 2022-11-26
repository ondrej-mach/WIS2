<?php

require_once 'includes/authorization-inc.php';
assert_logged_in();

if (!isset($_GET['points']) || !isset($_GET['termID']) || !isset($_GET['courseID'])) {
    exit('Wrong parameters');
}

require_once 'includes/courses-inc.php';
require_once 'includes/student-inc.php';
require_once 'includes/terms-inc.php';

$courseID = $_GET['courseID'];

$termID = $_GET['termID'];
$points = $_GET['points'];
$uid = getUID();

$lecturers = getLecturerIDs($courseID);

if (!(is_teacher() && (in_array($uid, $lecturers) || $uid == getGuarantorID($courseID)))) {
    dieForbidden();
}

foreach($points as $key => $value) {
    # check max points in backend
    $maxPoints = getTermByID($termID)->termMaxPoints;
    if ($value > $maxPoints) {
        header("location: evaluateterm.php?termID=$termID&error=1");
        exit;
    }
    if (isset($value) && $value != "") {
        try{
            updatePoints($value, $uid, $termID, $key);
        } catch (Exception $e) {
            header("location: evaluateterm.php?termID=$termID&error=1");
            exit;
        }
    }
}

header("location: evaluateterm.php?termID=$termID&success=1");
?>
