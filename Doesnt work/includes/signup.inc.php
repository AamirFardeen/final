<?php
// Here I check whether the user got to this page by clicking the proper signup button.
if (isset($_POST['signup-submit'])) {

  // I include the connection script so I can use it later.
  require 'dbh.inc.php';

  // I grab all the data which I passed from the signup form so I can use it later.
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  // Then I perform error handling to make sure I catch any errors made by the user.  
  // I check for any empty inputs. 
  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  // I check for an invalid username AND invalid e-mail.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invaliduidmail");
    exit();
  }
  // I check for an invalid username. In this case ONLY letters and numbers.// search pattern
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invaliduid&mail=".$email);
    exit();
  }
  // I check for an invalid e-mail.
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidmail&uid=".$username);
    exit();
  }
  // I check if the repeated password is NOT the same.
  else if ($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  }
  else {

    // I also need to include another error handler here that checks whether or the username is already taken. I  to do this using prepared statements
    // First I create the statement that searches my database table to check for any identical usernames.
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
    // I create a prepared statement.
    $stmt = mysqli_stmt_init($conn);
    // Then I prepare our SQL statement and check if there are any errors with it.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // If there is an error I send the user back to the signup page.
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      // Next I need to bind the type of parameters I  expect to pass into the statement, and bind the data from the user.
      mysqli_stmt_bind_param($stmt, "s", $username);
      // Then I execute the prepared statement and send it to the database!
      mysqli_stmt_execute($stmt);
      // Then I store the result from the statement.
      mysqli_stmt_store_result($stmt);
      // Then I get the number of result I received from our statement. This tells us whether the username already exists or not
      $resultCount = mysqli_stmt_num_rows($stmt);
      // Then I close the prepared statement!
      mysqli_stmt_close($stmt);
      // Here I check if the username exists.
      if ($resultCount > 0) {
        header("Location: ../signup.php?error=usertaken&mail=".$email);
        exit();
      }
      else {
        // If I got to this point, it means the user didn't make an error! 
        // Next thing I do is to prepare the SQL statement that will insert the users info into the database. I HAVE to do this using prepared statements to make this process more secure. DON'T JUST SEND THE RAW DATA FROM THE USER DIRECTLY INTO THE DATABASE!
        //  prepared statment helps from sql injection it is seciure
        // Prepared statements works by us sending SQL to the database first, and then later I fill in the placeholders (this is a placeholder -> ?) by sending the users data.
        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?, ?, ?);";
        // Here I initialize a new statement using the connection from the dbh.inc.php file.
        $stmt = mysqli_stmt_init($conn);
        // Then I prepare our SQL statement AND check if there are any errors with it.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          // If there is an error I send the user back to the signup page.
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {

          // Before I send ANYTHING to the database I HAVE to hash the users password to make it un-readable in case anyone gets access to our database without permission!
          // The hashing method is the latest version and  updates automatically. I didn not use md5 or sha256 to hash, these are old and outdated!
          //takin the informatio the user gave us and put into the database with that specifc sql statement given and now that statement ran first in the database and then we later give the information from the user it is much safer from the user into the database  doing this way is gonna run a different method from the database
        //the orginal password and what kind of way which is "decrypte: it atutomally udpates//
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          // Next I need to bind the type of parameters I expect to pass into the statement, and bind the data from the user.
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
          // Then I execute the prepared statement and send it to the database!
          // This means the user is now registered
          //we bind the parametes from the users to the statement we created up there which I take information from the user to the database
          mysqli_stmt_execute($stmt);
          // Lastly I send the user back to the signup page with a success message
          header("Location: ../signup.php?signup=success");
          exit();

        }
      }
    }
  }
  // Then I close the prepared statement and the database connection!
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // If the user tries to access this page an inproper way, we send them back to the signup page.
  header("Location: ../signup.php");
  exit();
}
