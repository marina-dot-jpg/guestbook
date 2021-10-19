<?php include("../../config.php");

$dir = getcwd();
$username = basename($dir);

    $query = "SELECT * FROM guestbooks WHERE gowner = 'saddie'";
    $result = mysqli_query( $con, $query ) or die(mysqli_error($con));
    $output = "";
    $output .= "<a href='submit.php'><button>Leave a Comment</button></a><br>";
    $output .= "<h1>" . $username . "'s Guestbook</h1>";
    $output .= "<table>";
    $output .= "<tr>";
    $output .= "<th>Date</th>
    <th>Nickname</th>
    <th>Email</th>
    <th>Comment</th>";
    $output .= "</tr>";
    while ($row = mysqli_fetch_array($result)) {
    $Gowner = $row["gowner"];
    $Nickname=$row["nickname"]; // <-- These vars need to match the case of the DB columns
    $Date=$row["dateposted"];
    $Email=$row["email"];
    $Comment=$row["comment"];
    $output .= "<tr>";
    $output .= "<td>$Gowner</td> <td>$Date</td> <td>$Nickname</td> <td>$Email</td> <td>$Comment</td>";
    $output .= "</tr>";
  }
  echo $output;
  
    ?>
