<?php
if(isset($_COOKIE["USER"]))
{
    echo "<script>window.location.href='users.php'</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  margin: auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
</style>
    
</head>
<body>
    <div class="container">
        <div class="login-page">
            <div class="form">
                <form method="post" class="register-form" enctype="multipart/form-data">
                    <input type="text" placeholder="name" name="username" required/>
                    <input type="password" placeholder="password" name="password" required/>
                    <input type="text" placeholder="email address" name="email" required/>
                    <input type="file" name="image" accept="image/*" title="profile picture" required/>
                    <button type="submit" name="create">create</button>
                    <p class="message">Already registered? <a>Sign In</a></p>
                    </form>
                    <form method="post" class="login-form">
                    <input type="email" placeholder="email" name="email" required/>
                    <input type="password" placeholder="password" name="password" required/>
                    <button type="submit" name="login">login</button>
                    <p class="message">Not registered? <a>Create an account</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    $('.message a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
</script>
<?php
    include "conn.php";
    if(isset($_POST["login"]))
    {
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $q = "SELECT * FROM `users` WHERE `EMAIL` LIKE '$email' AND `PASSWORD` LIKE '$password'";
        $run = mysqli_query($conn,$q);
        if($run)
        {
            if(mysqli_num_rows($run)>0)
            {
                setcookie("USER",$email,time()+60*60*24*30);
                echo "<script>window.location.href='users.php'</script>";
            }
        }
    }

    if(isset($_POST["create"]))
    {
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $img = $_FILES["image"]["name"];
        $temp_loc = $_FILES["image"]["tmp_name"];
        $dir = "img/".$img;
        
        $q = "INSERT INTO `users`(`ID`, `USERNAME`, `EMAIL`, `PASSWORD`, `IMG`) VALUES ('','$username','$email','$password','$img')";
        $run = mysqli_query($conn,$q);
        if($run)
        {
          move_uploaded_file($temp_loc,$dir);
          echo "<script>alert('Register successfully...please login to continue');</script>";
        }
    }
?>
