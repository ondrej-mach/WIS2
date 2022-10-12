<!-- begin footer -->

<?php
    date_default_timezone_set($_ENV['TZ']);
    $timestamp = time();
    $date_time = date("d-m-Y (D) H:i:s", $timestamp);
    echo $date_time;
?>

</body>
</html>

