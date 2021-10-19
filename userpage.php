<?php
include "../db/guestbook/config.php";

$html = "<link rel='stylesheet' href='css/style.css' media='all'>
</head>
<div class='topbar'></div>
<div id='container'>
      <div class='navbar'>
    <div class='item'><a href='/'>Home</a></div>
    <div class='item'><a href='register.php'>Register</a></div>
    <div class='item'><a href='login.php'>Login</a></div>
  </div>";

$username = 'sadness';

$stmt = $con->prepare("SELECT * FROM guestbooks WHERE gowner=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$output = "";
$output .= "<a href=\'submit.php\'><button>Leave a Comment</button></a><br>";
$output .= "<h1>" . $username . "\'s Guestbook</h1>";
$output .= "<table>";
$output .= "<tr>";
$output .= "<th>Date</th>
    <th>Nickname</th>
    <th>Email</th>
    <th>Comment</th>";
$output .= "</tr>";
while ($row = $result->fetch_assoc()) {
    $Gowner = $row["gowner"];
    $Nickname = $row["nickname"]; // <-- These vars need to match the case of the DB columns
    $Date = $row["dateposted"];
    $Email = $row["email"];
    $Comment = $row["comment"];
    $output .= "<tr>";
    $output .= "<td>$Date</td> <td>$Nickname</td> <td>$Email</td> <td>$Comment</td>";
    $output .= "</tr>";
}

?>

$username = 'sadness';

$stmt = $con->prepare("SELECT * FROM guestbooks WHERE gowner=?");
$stmt->bind_param("s", $username);
$stmt->execute();
print_r($stmt->errorInfo());
$result = $stmt->get_result();
$output = "";
$output .= "<a href=\'submit.php\'><button>Leave a Comment</button></a><br>";
$output .= "<h1>" . $username . "\'s Guestbook</h1>";
$output .= "<table>";
$output .= "<tr>";
$output .= "<th>Date</th>
    <th>Nickname</th>
    <th>Email</th>
    <th>Comment</th>";
$output .= "</tr>";
while ($row = $result->fetch_assoc()) {
    $Gowner = $row["gowner"];
    $Nickname = $row["nickname"]; // <-- These vars need to match the case of the DB columns
    $Date = $row["dateposted"];
    $Email = $row["email"];
    $Comment = $row["comment"];
    $output .= "<tr>";
    $output .= "<td>$Date</td> <td>$Nickname</td> <td>$Email</td> <td>$Comment</td>";
    $output .= "</tr>";
}

?>

    <?php $template = ob_get_clean();?>

    <?php echo $template; ?>