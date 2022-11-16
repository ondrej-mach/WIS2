<?php require_once 'includes/authorization-inc.php'; ?>

<!DOCTYPE html>
<html>
<?php 
include_once 'templates/header.php';
include_once 'templates/navbar.php';
if (is_student()) {
    echo "TODO prehled z navbaru";
}
if (is_teacher()) {
    echo "TODO prehled z navbaru";
}
if (is_admin()) {
    echo "TODO prehled z navbaru";
}
if (is_logged_in() && !is_admin() && !is_teacher() && !is_student()) {
    echo "TODO";
}
include_once 'templates/footer.php'; ?>
</html>