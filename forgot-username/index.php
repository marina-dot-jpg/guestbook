<?php
include("../config.php");

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$email) {
   $error .="<p>Invalid email address please type a valid email address!</p>";
   }else{
   $sel_query = "SELECT * FROM users WHERE email='".$email."'";
   $result = mysqli_query($con,$sel_query);
   $rowCount = mysqli_num_rows($result);
   if ($rowCount < 1){
   $error .= "<p>No user is registered with this email address: " . $email . " </p>";
   }
  }
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }else{
   // else goes here
   $usernames = "";
   while ($row = mysqli_fetch_array($result)) {
       $username = $row["username"];
       $usernames .= "$username <br>";
   }
   $myvariable = "hello";
    
    $to      = $email; // Send email to our user
    $subject = 'Forgot Username'; // Give the email a subject 
    $message = '
    
    You recently submitted a request for a forgotten username.
    
    The usernames associated with this email address are:<br>
    
    '.$usernames.'
    
    '; // Our message above including the link
                  
    $headers = 'From:noreply@sadgrl.leprd.space' . "\r\n"; // Set from headers
    $headers  .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($to, $subject, $message, $headers); // Send our email


echo "<div class='error'><p>An email message has been sent to you with your username.</p>
</div><br /><br /><br />";

   }
}else{
?>
<form method="post" action="" name="reset"><br /><br />
<label><strong>Enter Your Email Address:</strong></label><br /><br />
<input type="email" name="email" placeholder="username@email.com" />
<br /><br />
<input type="submit" value="Forgot Username"/>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php } ?>