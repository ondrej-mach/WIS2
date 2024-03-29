<?php
require_once 'includes/authorization-inc.php';
require_once 'includes/courses-inc.php';
    
if (!(is_teacher() || is_admin())) {
    dieForbidden();
}
    
if (!isset($_REQUEST["courseID"])) {
    exit('no courseID');
}
$courseID = $_REQUEST["courseID"];

if ($courseID == 'new') {    
    try {
        $courseID = addCourse($_REQUEST['courseName'], getUID());
        # add guarantor as a lecturer
        addLecturer($courseID, getUID());
    } catch (Exception $e) {
        header("location: createcourse.php?courseID=new");
        exit;
    }
}

$userParams = [ 
    "courseName",
    "courseFullName",
    "courseDescription",
    "courseState",
];

// when accountID is not set, it changes info for the logged in user.
// user cannot change these attributes, only admin can
$adminParams = [ 
    "courseCredits",
    "courseCapacity",
    "courseGuarantor",
    "courseOpen",
];

$attributes = [];
$guarantorChanged = false;

foreach ($_REQUEST as $key => $value) {
    if (in_array($key, $userParams)) {
        $attributes[$key] = $value;
        
    } elseif (in_array($key, $adminParams)) {
        if ($key == "courseGuarantor") {
            $guarantorID = getGuarantorID($courseID);
            if (!is_admin() && $guarantorID != getUID()) {
                dieForbidden();
            }
            if ($guarantorID != $value) {
                $guarantorChanged = true;
            }
        }
        $attributes[$key] = $value;
    }
}

# if we need to change any data, access the database
if (!empty($attributes)) {
    try{
        modifyCourse($courseID, $attributes);
    } catch (Exception $e) {
        header("location: editcourse.php?courseID=$courseID&error=1");
        exit;
    }
}

if ($guarantorChanged) {
    header("location: teachercourses.php");
} else {
    header("location: editcourse.php?courseID=$courseID&success=1");
}
?>
