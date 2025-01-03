<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post">
  <div class="container">
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter email" name="email" required>

    <label for="user"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="user" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label for="psw"><b>Repeat password</b></label>
    <input type="password" placeholder="Repeat Password" name="pswR" required>

  </div>

  <div class="container" style="padding-top: 10px">
    <button type="button"><a href="images">Cancel</a></button> 
    <button type="submit">Create Account</button><br/>
    <br/>
    <label for="c"><b>Already have an account? </b></label><button name="c"type="button"><a href="login">Login</a></button>
  </div>
</form> 

</body>
</html>
