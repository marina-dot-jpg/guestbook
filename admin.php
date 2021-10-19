<?php
include "config.php";
include "crudcode.php";



// Check user login or not
if(!isset($_SESSION['uname'])){
  header('Location: index.php');
  }else {
      
// logout
if(isset($_POST['but_logout'])){
    session_destroy();
}

$username = $_SESSION['uname'];
$urlprefix = 'https://sadgrl.leprd.space/guestbook/users/';

$nickname = mysqli_real_escape_string($con,$_GET['nickname']);
$date = mysqli_real_escape_string($con,$_GET['dateposted']);
$email = mysqli_real_escape_string($con,$_GET['email']);
$comment = mysqli_real_escape_string($con,$_GET['comment']);
$output = "";
echo $nickname;

    $stmt = $con->prepare("SELECT * FROM `guestbooks` WHERE `gowner` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
    $Date = $row["dateposted"];
    $Nickname = $row["nickname"];
    $Email = $row["email"];
    $Comment = $row["comment"];
    $output .= "<br>";
    $output .= "<strong> Date: </strong> $Date <br>";
    $output .= "<strong> Nickname: </strong> $Nickname <br>";
    $output .= "<strong> Email: </strong> $Email <br>";
    $output .= "<strong> Comment:</strong> $Comment <br>";
    $output .= "<a href='crudcode.php?del=" . $row["id"] . "' class='del_btn'>Delete</a><br><br>";
    $output .= "</tr>";
    
    }
    
    
}
 ?>
<!doctype html>
<html>
    <head></head>
    <body>
        <div class="container">
        <div class="logOut">
            <form method='post' action="login.php">
            <input type="submit" value="Logout" name="but_logout">
        </form>
        </div>
        <h1><?php echo $username ?>'s Guestbook</h1>
        <p>Welcome to your very own Guestbook!<br><br>
        Your public guestbook is <a href=" <? echo $urlprefix . $username; ?>">here</a>.<br>
        Below is your <strong>admin</strong> view, where you can delete comments.<br>
        
        
        <?php echo $output; ?>
        </div>
        <style>
            .container {
                width:800px;
                margin:0 auto;
                font-family:verdana;
            }
            .logOut {
                float:right;
            }
            th {
                text-align:left;
                padding-right:40px;
            }
            td {
                padding-right:40px;
            }
        </style>
    </body>
</html>