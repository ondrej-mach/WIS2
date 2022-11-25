<?php
require_once 'includes/authorization-inc.php';

assert_admin();

$rid = $_REQUEST["roomID"];

$roomParams = [ 
    "roomName",
    "roomDescription",
];

$attributes = [];

foreach ($_POST as $key => $value) {
    if (in_array($key, $roomParams)) {
        $attributes[$key] = $value;
    }
}

if (!empty($attributes)) {
    require_once 'includes/rooms-inc.php';
    roomMod($rid, $attributes);
}
?>

<!DOCTYPE html>
<html>

<?php include_once 'templates/header.php' ?>
<?php include_once 'templates/navbar.php' ?>
<?php
    if (is_admin()) {
        echo '<div id="button_back"><a href="managerooms.php">Back to manage rooms</a></div>';
    }
?>
</section>

<section class="section_form">
<h3>Modify room</h3>
<div>
    <form method="POST">
        <?php
            $disabled = is_admin() ? '' : 'disabled';
            
            require_once 'includes/rooms-inc.php';
            $room = getRoomByID($rid);
                    
            echo "<label>Room name*<input name=\"roomName\" type=\"text\" 
            $disabled value=\"$room->roomName\" required></label><br/>";
            
            echo '<label>Room description<input name="roomDescription" type="text" value="' .
            $room->roomDescription . '"></label><br/>';        
        ?>

        <button type="submit" name="submit">Update</button>
    </form>
</div>
</section>

<?php include_once 'templates/footer.php' ?>

</html>
