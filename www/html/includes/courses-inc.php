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

function courseStateToInt($state) {
    switch ($state) {
        case CourseState::CONCEPT:
        case CourseState::CONCEPT->value:
            return 0;
            
        case CourseState::FOR_APPROVAL:
        case CourseState::FOR_APPROVAL->value:
            return 5;
            
        case CourseState::RUNNING:
        case CourseState::RUNNING->value:
            return 10;
    }
}


function getEmptyCourse() {
    $course = (object) [
        'courseID' => 0,
        'courseName' => '',
        'courseFullName' => '',
        'courseDescription' => '',
        'courseCredits' => 0,
        'courseCapacity' => 0,
        'courseState' => CourseState::CONCEPT
    ];
    return $course;
}

function getCourses() {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT * FROM Course");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function getCoursesGuaranteedBy($accountID) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT * FROM Course NATURAL JOIN Guarantees WHERE accountID = ?");
    $stmt->execute([$accountID]);
    return $stmt->fetchAll(PDO::FETCH_CLASS);
}

function getCourseByID($courseID) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT * FROM Course WHERE courseID = ?");
    $stmt->execute([$courseID]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function addCourse($name, $guarantorID) {
    $conn = $GLOBALS['conn'];
    $conn->beginTransaction();
    
    $stmt = $conn->prepare("INSERT INTO Course (courseName, courseState) VALUES (?, ?)");
    $stmt->execute([$name, CourseState::CONCEPT->value]);
    $newCourseID = $conn->lastInsertId();
    
    $stmt = $conn->prepare("INSERT INTO Guarantees (accountID, courseID) VALUES (?, ?)");
    $stmt->execute([$guarantorID, $newCourseID]);
    
    $conn->commit();
    return $newCourseID;
}

function deleteCourse($courseID) {
    #TODO: delete all the other stuff
    $conn = $GLOBALS['conn'];
    $sql = "DELETE FROM Course WHERE courseID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$courseID]);
}

function getGuarantorID($courseID) {
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("SELECT accountID FROM Guarantees WHERE courseID = ?");
    $stmt->execute([$courseID]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->accountID;
}

function getLecturerIDs($courseID) {
    $lecturers = [];
    $conn = $GLOBALS['conn'];
    
    $stmt = $conn->prepare("SELECT accountID FROM Lecturer WHERE courseID = ?");
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
        "courseCredits",
        "courseCapacity",
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

function removeAllTermsfromCourse($courseID) {
    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM Term WHERE courseID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$courseID]);
}

function removeGuarantor($courseID) {
    $conn = $GLOBALS['conn'];

    $sql = "DELETE FROM Guarantees WHERE courseID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$courseID]);
}
?>
