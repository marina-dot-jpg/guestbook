<?php
include "config.php";

if (isset($_POST['btnsignup'])) {
    header('Location: success.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Guestbook Registration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style.css" media="all">
<?php
$error_message = "";
$success_message = "";

// Register user
if (isset($_POST['btnsignup'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $name = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmpassword = mysqli_real_escape_string($con, $_POST['confirmpassword']);
    $hash = md5(rand(0, 1000)); // Generate random 32 character hash and assign it to a local variable.
    // Example output: f4552671f8909587cf485ea990207f3b

    $to = $email; // Send email to our user
    $subject = 'Guestbook Verification'; // Give the email a subject
    $message = '

    Your guestbook account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

    ------------------------
    Username: ' . $username . '
    ------------------------

    Please click this link to activate your account:
    https://sadgrl.leprd.space/guestbook/verify.php?email=' . $email . '&hash=' . $hash . '

    '; // Our message above including the link

    $headers = 'From:noreply@sadgrl.leprd.space' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email

    // Check fields are empty or not
    if ($email == '' || $username == '' || $name == '' || $password == '' || $confirmpassword == '') {
        $error_message = "Please fill all fields.";
    }

    // Check if confirm password matching or not
    if ($password != $confirmpassword) {
        $error_message = "Confirm password not matching";
    }

    // Check if username already exists
    $stmt = $con->prepare("SELECT * FROM users WHERE username = '$username'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $error_message = "<div style='color:red; font-weight:strong; text-align:center;'>Username already exists. Please try a different one.</div>";
        echo $error_message;
    }

}

$hashedpass = password_hash($password, PASSWORD_DEFAULT);

// Insert records
$insertSQL = "INSERT INTO users(email,username,name,password,hash ) values(?,?,?,?,?)";
$stmt = $con->prepare($insertSQL);
$stmt->bind_param("sssss", $email, $username, $name, $hashedpass, $hash);
$stmt->execute();
$stmt->close();

$mkdir = mkdir("users/$username");
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
<link rel="stylesheet" href="css/style.css" media="all">
  </head>
  <body>

<div class="topbar"></div>
<div id="container">
      <div class="navbar">
    <div class="item"><a href="/">Home</a></div>
    <div class="item"><a href="register.php">Register</a></div>
    <div class="item"><a href="login.php">Login</a></div>
    </div>
      <div class='row'>

        <div class='col-md-6' >

          <form method='post' action=''>
<br><br>
            <h1>Sign up for your own guestbook!</h1>

            <div class="form-group">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" name="email" id="email" required="required" maxlength="80">
            </div>
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" id="name" required="required" maxlength="80">
            </div>
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" name="username" id="username" required="required" maxlength="80">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" id="password" required="required" maxlength="80">
            </div>
            <div class="form-group">
              <label for="pwd">Confirm Password:</label>
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" onkeyup='' required="required" maxlength="80">
            </div>

            <button type="submit" name="btnsignup" class="btn btn-default">Submit</button>
          </form>
        </div>
       </div>
     </div>
    </div>
  </body>
</html>