
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<div class="topbar"></div>
<div id="container">
      <div class="navbar">
    <div class="item"><a href="/">Home</a></div>
    <div class="item"><a href="register.php">Register</a></div>
    <div class="item"><a href="login.php">Login</a></div>
  </div>
    
    
    <?php include("../../config.php");

$dir = getcwd();
$username = basename($dir);

    $query = "SELECT * FROM guestbooks WHERE gowner = 'sad'";
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
    $output .= "<td>$Date</td> <td>$Nickname</td> <td>$Email</td> <td>$Comment</td>";
    $output .= "</tr>";
  }
  
    ?>
    
