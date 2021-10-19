<?php

include "../db/guestbook/config.php";

if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    $email = mysqli_real_escape_string($con, $_GET['email']); // Set email variable
    $hash = mysqli_real_escape_string($con, $_GET['hash']); // Set hash variable

    $stmt = $con->prepare("SELECT email, hash, active FROM users WHERE email='" . $email . "' AND hash='" . $hash . "' AND active=' 0 '");
    $stmt->bind_param("ss", $email, $hash);
    $stmt->execute();
    $stmt->store_result();
    $match = $stmt->num_rows();

    if ($match > 0) {
        $inactive = 0;
        $active = 1;

        $stmt = $con->prepare("UPDATE users SET active=? WHERE email=? AND hash=? AND active=?");
        $stmt->bind_param("ssss", $active, $email, $hash, $inactive);
        $stmt->execute();

        echo "<div style='text-align:center; font-weight:bold; color:green;'>Your account has been activated, you can now login</div>";
        echo "<meta http-equiv='refresh' content='2;url=http://sadgrl.leprd.space/guestbook/login.php'>";
    } else {
        // No match -> invalid url or account has already been activated.
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
    }

} else {
    // Invalid approach
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
}
