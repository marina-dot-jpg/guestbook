<?php
include "../db/guestbook/config.php";

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($con, "DELETE FROM guestbooks WHERE id = '$id';");
    $_SESSION['message'] = "Address " . $id . " is deleted!";
    echo $_SESSION['message'];
}
