<?php

require_once 'includes/dbh-inc.php';

function getTeacherIDs($courseID) {
    $stmt = $GLOBALS['conn']->prepare("SELECT accountID FROM Account WHERE accountTeacher = true");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    
    foreach($result as $teacher) {
        array_push($teachers, $teacher->accountID);
    }
    
    return $teachers;
}
