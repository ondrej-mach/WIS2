<?php

require_once 'includes/dbh-inc.php';

function getTeacherIDs() {
    $stmt = $GLOBALS['conn']->prepare("SELECT accountID FROM Account WHERE accountTeacher = true");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    
    $teachers = [];
    foreach($result as $teacher) {
        array_push($teachers, $teacher->accountID);
    }
    
    return $teachers;
}


function getCoursesForTeacher($accountID) {
    $stmt = $GLOBALS['conn']->prepare("
        SELECT courseID, courseName, courseFullName, courseState, courseCapacity, true AS is_guarantor
        FROM Course NATURAL JOIN Guarantees WHERE accountID = ?
        UNION
        SELECT courseID, courseName, courseFullName, courseState, courseCapacity, false AS is_guarantor
        FROM Course NATURAL JOIN Lecturer WHERE accountID = ?; 
    ");
    $stmt->execute([$accountID, $accountID]);
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}
?>
