<p>
<?php
date_default_timezone_set('Asia/Kolkata');

$timestamp = time();
$date_time = date("d-m-Y (D) H:i:s", $timestamp);
echo $date_time;
?>
</p>
