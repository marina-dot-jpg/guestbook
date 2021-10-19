<?php
include("../config.php");

if(isset($_POST["username"]) && (!empty($_POST["username"]))){
$username = $_POST["username"];

   $sel_query = "SELECT * FROM users WHERE username='".$username."'";
   $result = mysqli_query($con,$sel_query);
   $numRow = mysqli_num_rows($result);
   if ($numRow < 1){
   $error .= "<p>No user is registered with this username: " . $username . " </p>";
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }else{
   $expFormat = mktime(
   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
   );
   $expDate = date("Y-m-d H:i:s",$expFormat);
   $key = md5(2418*2+$username);
   $addKey = substr(md5(uniqid(rand(),1)),3,10);
   $key = $key . $addKey;
   while ($row = mysqli_fetch_array($result)) {
    $email = $row["email"];
   }
// Insert Temp Table
mysqli_query($con,
"INSERT INTO `password_reset_temp` (`username`, `key`, `expDate`)
VALUES ('".$username."', '".$key."', '".$expDate."');");

    $to      = $email; // Send email to our user
    $subject = 'Forgot Password'; // Give the email a subject 
    $message = '
    
    Please click on the following link to reset your password.
    
    https://sadgrl.leprd.space/guestbook/forgot-password/reset-password.php?
key='.$key.'&username='.$username.'&action=reset

    The link will expire after 1 day for security reasons.
    
If you did not request this forgotten password email, no action 
is needed, your password will not be reset. However, you may want to log into 
your account and change your security password as someone may have guessed it.
    
    '; // Our message above including the link
                  
    $headers = 'From:noreply@sadgrl.leprd.space' . "\r\n"; // Set from headers
    mail($to, $subject, $message, $headers); // Send our email


echo "<div class='error'>
<p>An email has been sent to you at" . $email . " with instructions on how to reset your password.</p>
</div><br /><br /><br />";

   }
}else{
?>
<form method="post" action="" name="reset"><br /><br />
<label><strong>Enter Your Username:</strong></label><br /><br />
<input type="username" name="username" placeholder="username" />
<br /><br />
<input type="submit" value="Reset Password"/>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>