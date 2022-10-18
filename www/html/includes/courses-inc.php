<?php

require_once 'includes/dbh-inc.php';

enum CourseState: int
{
    case CONCEPT = 0;
    case FOR_APPROVAL = 5;
    case RUNNING = 10;
}

function courseStateToString($state) {
    switch ($state) {
        case CourseState::CONCEPT:
        case CourseState::CONCEPT->value:
            return 'Concept';
            
        case CourseState::FOR_APPROVAL:
        case CourseState::FOR_APPROVAL->value:
            return 'To be approved';
            
        case CourseState::RUNNING:
        case CourseState::RUNNING->value:
            return 'Running';
    }
}



function getEmptyCourse() {
    $course = (object) [
        'courseID' => 0,
        'courseName' => '',
        'courseFullName' => '',
        'courseDescription' => '',
        'courseState' => CourseState::CONCEPT
    ];
    return $course;
}

function getCourses() {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Course");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function getCoursesGuaranteedBy($accountID) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Course NATURAL JOIN Guarantees WHERE accountID = ?");
    $stmt->execute([$accountID]);
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function getCourseByID($courseID) {
    $stmt = $GLOBALS['conn']->prepare("SELECT * FROM Course WHERE courseID = ?");
    $stmt->execute([$courseID]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function addCourse($name, $guarantorID) {
    $conn = $GLOBALS['conn'];
    $conn->beginTransaction();
    
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO Course (courseName, courseState) VALUES (?, ?)");
    $stmt->execute([$name, CourseState::CONCEPT->value]);
    $newCourseID = $conn->lastInsertId();
    
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO Guarantees (accountID, courseID) VALUES (?, ?)");
    $stmt->execute([$guarantorID, $newCourseID]);
    
    $conn->commit();
    return $newCourseID;
}

function getGuarantorID($courseID) {
    $stmt = $GLOBALS['conn']->prepare("SELECT accountID FROM Guarantees WHERE courseID = ?");
    $stmt->execute([$courseID]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->accountID;
}

function getLecturerIDs($courseID) {
    $lecturers = [ ];
    
    $stmt = $GLOBALS['conn']->prepare("SELECT accountID FROM Lecturer WHERE courseID = ?");
    $stmt->execute([$courseID]);
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    
    foreach($result as $lecturer) {
        array_push($lecturers, $lecturer->accountID);
    }
    
    return $lecturers;
}

function modifyCourse($courseID, $attributes) {
    $conn = $GLOBALS['conn'];
    
    $possibleAttr = [ 
        "courseName",
        "courseFullName",
        "courseDescription",
        "courseState",
        "courseGuarantor"
    ];
    
    foreach($attributes as $key => $value) {
        if (!in_array($key, $possibleAttr)) {
            throw new Exception("Attribute $key does not exist.");
        }
        
        if ($key == "courseGuarantor") {
            $conn->beginTransaction();
            $sql = "DELETE FROM Guarantees WHERE courseID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$courseID]);
            
            $sql = "INSERT INTO Guarantees (accountID, courseID) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$value, $courseID]);
            $conn->commit();
        } else {
            $sql = "UPDATE Course SET $key = ? WHERE courseID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$value, $courseID]);
        }
    }
}


function addLecturer($courseID, $accountID) {
    $conn = $GLOBALS['conn'];

    $sql = "INSERT INTO Lecturer (accountID, courseID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$accountID, $courseID]);
    
    return $conn->lastInsertId();
}

function removeLecturer($courseID, $accountID) {
    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM Lecturer WHERE courseID = ? AND accountID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$courseID, $accountID]);
}
