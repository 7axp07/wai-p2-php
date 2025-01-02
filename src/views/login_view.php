<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="static/css/styles.css"/>
</head>
<body>

<form method="post">
  <div class="container">
    <label for="user"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="user" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

  </div>

  <div class="container" style="background-color:#f1f1f1; padding-top: 5px">
    <button type="button"><a href="images">Cancel</a></button> 
    <button type="submit">Login</button><br/>
    <br/>
    <button type="button">Create account</button>
  </div>
</form> 

</body>
</html>
