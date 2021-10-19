<?php
include "../db/guestbook/config.php";

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

$mkdir = mkdir("/home/sadness/public_html/guestbook/users/$username");
$createPublicPage = fopen("/home/sadness/public_html/guestbook/users/$username/index.php", 'w');
$createSubmitPage = fopen("/home/sadness/public_html/guestbook/users/$username/submit.php", 'w');

fwrite($createPublicPage, '<?php
$dir = getcwd();
$username = basename($dir);

include "../../../db/guestbook/config.php";
include "../../userpage.php";');

fwrite($createSubmitPage, '<?php
$dir = getcwd();
$username = basename($dir);

include "../../../db/guestbook/config.php";
include "../../usersubmit.php";');

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