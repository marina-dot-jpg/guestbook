<?php $mkdir = mkdir("users/$username");
$createPublicPage = fopen("users/$username/index.php", 'w');
$createSubmitPage = fopen("users/$username/submit.php", 'w');

fwrite($createPublicPage, '<link rel="stylesheet" href="css/style.css" media="all">
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

    $query = "SELECT * FROM guestbooks WHERE gowner = ' . "'$username'" . '";
    $result = mysqli_query( $con, $query ) or die(mysqli_error($con));
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

');
fwrite($createSubmitPage, '<?php include("../../config.php");

$dir = getcwd();
$username = basename($dir);
?>
<?php
$error_message = "";$success_message = "";

if($_SERVER[\'REQUEST_METHOD\'] == \'POST\') {
    header(\'Location: index.php\');
}
// Submit Comment
if(isset($_POST["btnComment"])){
   $nickname = trim($_POST["nickname"]);
   $email = trim($_POST["email"]);
   $comment = trim($_POST["comment"]);
   $dateposted = date("Y-m-d");
   $gowner = $username;

   // Check fields are empty or not
   if ($nickname == "" || $email == "" || $comment == ""){
     $error_message = "Please fill all fields.";
   }

   // Insert records
     $insertSQL = "INSERT INTO guestbooks(gowner,dateposted,nickname,email,comment) values(?,?,?,?,?)";
     $stmt = $con->prepare($insertSQL);
     $stmt->bind_param("sssss",$gowner, $dateposted, $nickname,$email,$comment);
     $stmt->execute();
     $stmt->close();

     $success_message = "Comment posted successfully.";
     echo $success_message;
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Submit Comment</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">

        <div class="col-md-6" >

          <form method="post" action="">

            <h1>Sign <?php echo $username . "\'s" ?> Guestbook</h1>

            <div class="form-group">
            <div class="form-group">
              <label for="nickname">Nickname:</label>
              <input type="text" class="form-control" name="nickname" id="nickname" required="required" maxlength="30">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" id="email" required="required" maxlength="35">
            </div>
            <div class="form-group">
              <label for="comment">Comment:</label>
              <textarea class="form-control" name="comment" id="comment" onkeyup="" required="required" maxlength="10000"></textarea>
            </div>

            <button type="submit" name="btnComment" class="btn btn-default">Submit</button>
          </form>
        </div>

     </div>
    </div>
  </body>
</html>')

?>
