<?php 
include "config.php";
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

<?php 
$error_message = "";$success_message = "";

// Submit Comment
if(isset($_POST['btnComment'])){
   $nickname = trim($_POST['nickname']);
   $email = trim($_POST['email']);
   $comment = trim($_POST['comment']);
   $dateposted = date("Y-m-d");
   $gowner = 'sadness';

    echo $dateposted;

   // Check fields are empty or not
   if ($nickname == '' || $email == '' || $comment == ''){
     $error_message = "Please fill all fields.";
   }

   // Insert records
     $insertSQL = "INSERT INTO guestbooks(gowner, dateposted, nickname,email,comment ) values(?,?,?,?,?)";
     $stmt = $con->prepare($insertSQL);
     $stmt->bind_param("sssss",$gowner, $dateposted, $nickname,$email,$comment);
     $stmt->execute();
     $stmt->close();

     $success_message = "Comment posted successfully.";
     
?>
  </head>
  <body>
    <div class='container'>
      <div class='row'>

        <div class='col-md-6' >

          <form method='post' action=''>

            <h1>SignUp</h1>
            <?php 
            // Display Error message
            if(!empty($error_message)){
            ?>
            <div class="alert alert-danger">
              <strong>Error!</strong> <?= $error_message ?>
            </div>

            <?php
            }
            ?>

            <?php 
            // Display Success message
            if(!empty($success_message)){
            ?>
            <div class="alert alert-success">
              <strong>Success!</strong> <?= $success_message ?>
            </div>

            <?php
            }
            ?>

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
              <textarea class="form-control" name="comment" id="comment" onkeyup='' required="required" maxlength="10000"></textarea>
            </div>

            <button type="submit" name="btnComment" class="btn btn-default">Submit</button>
          </form>
        </div>

     </div>
    </div>
  </body>
</html>