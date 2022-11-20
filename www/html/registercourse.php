<?php 
    require_once 'includes/authorization-inc.php'; 
    if (!is_student()) {
        dieForbidden();
    }
    if (!isset($_GET['courseID']) || !isset($_GET['studentID']) || !isset($_GET['action'])) {
        exit('Wrong parameters');
    }
    $courseID = $_GET['courseID'];
    $studentID = $_GET['studentID'];
    $action = $_GET['action'];

require_once 'includes/courses-inc.php';
require_once 'includes/student-inc.php';
require_once 'includes/terms-inc.php';

if (!is_student() || $studentID != getUID()) {
    dieForbidden();
}

if ($action == "add") {
    #TODO sign student into all auto terms
    $course = getCourseByID($courseID);
    if ($course->courseOpen) {
        setRegistration($courseID, $studentID, 1);
    } else {
        setRegistration($courseID, $studentID, 0);
    }
} else if ($action == "remove") {
    removeRegistration($courseID, $studentID);
}

header("location: studentcourses.php");
?>