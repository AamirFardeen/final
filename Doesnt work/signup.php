<?php
session_start();
require_once "config.php";

if (isset($_POST['signup'])){
  unset($error);
  $username = $mysqli -> real_escape_string(stripslashes(strip_tags($_POST["Susername"])));
  $password = $mysqli -> real_escape_string(($_POST["Spassword"]));
  $email = $mysqli -> real_escape_string(stripslashes(strip_tags($_POST["Semail"])));
  
  $sql = 'SELECT * FROM Accounts WHERE Name = "'.$username.'"';
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0){
  $error = "This username is already taken!<br>";
  }
  else{
  $sql = 'SELECT * FROM Accounts WHERE Email = "'.$email.'"';
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0){
  $error = "This email is being used by another account!<br>";
  }
  else{
    $sql= "SELECT UserID FROM Accounts ORDER BY UserID DESC LIMIT 1";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $LastId = $row['UserID']+1;
    $sql = "INSERT INTO Accounts (UserID, Name, Password, Email) VALUES ('$LastId','$username','$password','$email')";
   if ($mysqli->query($sql)){
     $_SESSION["loggedIn"] = TRUE;
     $_SESSION["username"] = $username;
     $_SESSION["userID"] = $LastId;
     $_SESSION["email"] = $email;
   }
   else{
     echo("Error creating account. Please try again later.");
   }
  }
}
}
else if (isset($_POST["login"])){
  $username = $mysqli -> real_escape_string(stripslashes(strip_tags($_POST["Lusername"])));
  $password = $mysqli -> real_escape_string($_POST["Lpassword"]);
  $sql = "SELECT * FROM Accounts WHERE Name = '$username'";
  $result = $mysqli->query($sql);
  if ($result->num_rows == 0){
    $error2 = "There is no account associated with this username!<br>";
  }
  else{
    $sql = "SELECT * FROM Accounts WHERE Name = '".$username."'AND Password = '".$password."'";
    $result = $mysqli->query($sql);
    if($result->num_rows == 1){
      $row = $result->fetch_row();
      $_SESSION["loggedIn"] = TRUE;
      $_SESSION["username"] = $row[1];
      $_SESSION["userID"] = $row[0];
      $_SESSION["email"] = $row[3];
    }
    else{
      $error2 = "Invalid username or password!<br>";
    }
  }
}
?>
<!DOCTYPE HTML>
<html>
  <body>
      <h1>Sign Up</h1><br>
      <form class = "submitPres" id = "sForm" method = "POST">
        <label>Username: </label><br><input name = "Susername" type = "text" placeholder = "Username" required><br><br>
        <label>Email: </label><br><input name = "Semail" type = "email" placeholder = "Email Address" required><br><br>
        <label>Password: </label><br><input name = "Spassword" type = "password" placeholder = "Password" pattern = ".{5,}" required><br><br>
        <span class= "error">
          <?php
          if (isset($error)){
            echo ($error);
          }
          ?>
        </span>
        <button type = "submit" name = "signup">Sign Up</button>
      </form>
      <h1>Login</h1>
      <form class = "submitPres" id = "lForm" method = "POST">
        <label>Username: </label><br><input name = "Lusername" type = "text" placeholder = "Username" required><br><br>
        <label>Password: </label><br><input name = "Lpassword" type = "password" placeholder = "Password" pattern = ".{5,}" required><br><br>
        <span class= "error">
          <?php
          if (isset($error2)){
            echo ($error2);
          }
          ?>
        </span>
        <button type = "submit" class = "submit" name = "login">Login</button>
      </form>
  </body>
</html>