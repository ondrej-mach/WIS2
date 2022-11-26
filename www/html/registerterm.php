<?php
require_once 'includes/authorization-inc.php';
require_once 'includes/terms-inc.php';
require_once 'includes/student-inc.php';

if (!isset($_REQUEST["termID"])) {
    exit('no termID');
}

$termID = $_REQUEST['termID'];
$term = getTermByID($termID);

if (!is_admin() && !doesStudentAttend($term->courseID, getUID()))
    dieForbidden();

signStudentToTerm($termID, getUID(), 0);

header("location: studentcourse.php?courseID=$term->courseID");
?>
