<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="css/signin.css" rel="stylesheet">
</head>
<body  class="text-center" >
<form class="form-signin" method="post">
  <img class="mb-4" src="images/login_image.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
  <label for="email" class="sr-only">Email address</label>
  <input type="email" id="email" name="email"class="form-control" placeholder="Email address" required autofocus>
  <label for="pass" class="sr-only">Password</label>
  <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
  <?php
        include("include/signin_user.php");
    ?>
  <input class="btn btn-lg btn-primary btn-block" type="submit" name="sign_in" value="SIGN IN">
  
  <div class="small">Don't have an account? <a href="signup.php">create one</a></div>
  <br>

  <p class="my-5 mb-3 text-muted">&copy; 2020-2021</p>
</form>
</body>
</html>