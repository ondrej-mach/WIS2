
<footer>
    <div>
        <?php
            $timestamp = time();
            $date_time = date("d-m-Y (D) H:i:s", $timestamp);
            echo "<div>";
            echo $date_time;
            echo "</div>";
        ?>
    </div>
</footer>

</body>

</html>