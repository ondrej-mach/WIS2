<?php
require_once 'includes/authorization-inc.php';

assert_logged_in();

$uid = $GLOBALS['user']->accountID;
if (isset($_REQUEST["accountID"])) {
    assert_admin();
    $uid = $_REQUEST["accountID"];
}

$userParams = [ 
    "accountRealName",
    "accountPassword",
    "accountAddress",
    "accountDateOfBirth",
    "accountEmail",
];

// when accountID is not set, it changes info for the logged in user.
// user cannot change these attributes, only admin can
$adminParams = [ 
    "accountUsername", 
    "accountStudent", 
    "accountTeacher", 
    "accountAdmin",
];

$attributes = [];

foreach ($_POST as $key => $value) {
    if (in_array($key, $userParams)) {
        $attributes[$key] = $value;        
    } elseif (in_array($key, $adminParams)) {
        assert_admin();
        $attributes[$key] = $value;
    }
}

# if we need to change any data, access the database
if (!empty($attributes)) {
    require_once 'includes/users-inc.php';
    try{
        userMod($uid, $attributes);
    } catch (Exception $e) {
        header("location: usermod.php?error=1".(isset($_REQUEST["accountID"]) ? "&accountID=".$_REQUEST["accountID"] : ""));
        exit;
    }
    header("location: usermod.php?success=1".(isset($_REQUEST["accountID"]) ? "&accountID=".$_REQUEST["accountID"] : ""));
}

?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>

<?php
if (is_admin()) {
    echo '<div id="button_back" ><a href=manageusers.php>Back to user management</a></div><br/>';
}
else {
    echo '<div id="button_back" ><a href=index.php>Back to index</a></div><br/>';
}
?>
</section>

<section class="section_form">
    <h3>Edit info</h3>
    
    <?php
        if (isset($_REQUEST["success"])) {
            echo '<p style="color: green;">Successfully saved</p>';
        }
        else if (isset($_REQUEST["error"])) {
            echo '<p style="color: red;">Error: could not modify user info</p>';
        }
        echo "<div><form method=\"POST\">";
        $disabled = is_admin() ? '' : 'disabled';
        
        require_once 'includes/users-inc.php';
        $account = getUserByID($uid);
        
        echo "<label>Username*<input name=\"accountUsername\" type=\"text\" 
        $disabled value=\"$account->accountUsername\" required></label><br/>";
        
        echo '<label>Name*<input name="accountRealName" type="text" value="'.
        $account->accountRealName.'" required></label><br/>';
        
        echo '<label>Address<input name="accountAddress" type="text" value="'.
        $account->accountAddress.'"></label><br/>';

        echo '<label>Date of birth<input name="accountDateOfBirth" type="date" value="'.
        $account->accountDateOfBirth.'"></label><br/>';
    
        echo '<label>Email<input name="accountEmail" type="text" value="'.
        $account->accountEmail.'"></label><br/>';
        
        #TODO uncheck user not working properly
        $checked_a = $account->accountAdmin ? 'checked' : '';
        $checked_t = $account->accountTeacher ? 'checked' : '';
        $checked_s = $account->accountStudent ? 'checked' : '';
        if (is_admin()) {
            echo '  <label>Admin
                        <input type="hidden" name="accountAdmin" value="off">
                        <input type="checkbox" name="accountAdmin"'.$checked_a.'>
                    </label><br/>';

            echo '  <label>Teacher
                        <input type="hidden" name="accountTeacher" value="off">
                        <input type="checkbox" name="accountTeacher"'.$checked_t.'>
                    </label><br/>';

            echo '  <label>Student
                        <input type="hidden" name="accountStudent" value="off">
                        <input type="checkbox" name="accountStudent"'.$checked_s.'>
                    </label><br/>';
        }
    ?>
        <button type="submit" name="submit">Update</button>
    </form>
</div>
</section>

<?php include_once 'templates/footer.php' ?>

</html>
