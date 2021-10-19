<?php
include "config.php";

if(isset($_POST['but_submit'])){

$username = mysqli_real_escape_string($con,$_POST['username']);
$password = mysqli_real_escape_string($con,$_POST['password']);

    $result = mysqli_fetch_assoc(mysqli_query($con, "SELECT password FROM users WHERE active = '1' AND username = '" . $username . "'"));
    $password_hash = (isset($result['password']) ? $result['password'] : '');
    $result = password_verify($password, $password_hash);

if($result){
    $_SESSION['uname'] = $username;
    header('Location: admin.php');
}else{
    $msg = "<div style='text-align:center; font-weight:bold; color:red; margin-bottom:10px;'> Login Failed! Please make sure that you enter the correct details and that you have activated your account.</div>";
    echo $msg;
}
}
?>
<head>
<link rel="stylesheet" href="css/style.css" media="all">
</head>
<div class="topbar"></div>
<div id="container">
      <div class="navbar">
    <div class="item"><a href="/">Home</a></div>
    <div class="item"><a href="register.php">Register</a></div>
    <div class="item"><a href="login.php">Login</a></div>
  </div>
    <form method="post" action="">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" id="username" name="username" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" id="password" name="password" placeholder="Password"/>
            </div>
            <p style="font-size:10px; margin-left:10px;">Forgot your password? Click <a href="forgot-password/">here</a> to reset it.</a>
            <br>Forgot your username? Click <a href="forgot-username/">here</a> to reset it.</a></p>
            
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
    </form>
</div>

<style>

/* Login */
#div_login{
    border: 1px solid gray;
    border-radius: 3px;
    width: 470px;
    height: 270px;
    box-shadow: 0px 2px 2px 0px  gray;
    margin: 0 auto;
    margin-top:20px;
}

#div_login h1{
    margin-top: 0px;
    font-weight: normal;
    padding: 10px;
    background-color: cornflowerblue;
    color: white;
    font-family: sans-serif;
}

#div_login div{
    clear: both;
    margin-top: 10px;
    padding: 5px;
}

#div_login .textbox{
    width: 96%;
    padding: 7px;
}

#div_login input[type=submit]{
    padding: 7px;
    width: 100px;
    background-color: lightseagreen;
    border: 0px;
    color: white;
}

</style>