<?php
    require_once 'includes/authorization-inc.php';
    
    if (!is_teacher()) {
        dieForbidden();
    }
    
    if (isset($_REQUEST['courseName'])) {
        require_once 'includes/courses-inc.php';
        
        try {
            $newCourseID = addCourse($_REQUEST['courseName'], getUID());
        } catch (Exception $e) {
            header("location: editcourse.php?courseID=new");
            exit;
        }
    }
    
    header("location: modify.php?courseID=$newCourseID");

