<?php
// Here I check whether the user got to this page by clicking the proper login button.
if (isset($_POST['login-submit'])) {

  // I include the connection script so I can use it later.
  // I don't have to close the MySQLi connection since it is done automatically,this will immediately return resources to PHP and MySQL, which can improve performance.
  require 'dbh.inc.php';

  // I grab all the data which I  passed from the signup form so I can use it later.
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

  // Then I perform rror handling to 
  // I check for any empty inputs.
  if (empty($mailuid) || empty($password)) {
    header("Location: ../homepage.php?error=emptyfields&mailuid=".$mailuid);
    exit();
  }
  else {

    // If I got to this point, it means the user didn't make an error
    // Next I need to get the password from the user in the database that has the same username as what the user typed in, and then I need to de-hash it and check if it matches the password the user typed into the login form.
    // I will connect to the database using prepared statements which work by us sending SQL to the database first, and then later we fill in the placeholders by sending the users data.
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    // Here I initialize a new statement using the connection from the dbh.inc.php file.
    $stmt = mysqli_stmt_init($conn);
    // Then I prepare our SQL statement AND check if there are any errors with it.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // If there is an error I send the user back to the signup page.
      header("Location: ../homepage.php?error=sqlerror");
      exit();
    }
    else {

      // If there is no error then I continue the script
      // Next I need to bind the type of parameters I expect to pass into the statement, and bind the data from the user.
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      // Then I execute the prepared statement and send it to the database!
      mysqli_stmt_execute($stmt);
      // And i get the result from the statement.
      $result = mysqli_stmt_get_result($stmt);
      // Then i store the result into a variable.
      if ($row = mysqli_fetch_assoc($result)) {
        // Then I match the password from the database with the password the user submitted. The result is returned as a boolean.
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        // If they don't match then we create an error message!
        if ($pwdCheck == false) {
          // If there is an error i send the user back to the signup page.
          header("Location: ../homepage.php?error=wrongpwd");
          exit();
        }
        // Then if they DO match, then I know it is the correct user that is trying to log in!
        else if ($pwdCheck == true) {

          // Next I need to create session variables based on the users information from the database. If these session variables exist, then the website will know that the user is logged in.
          // Now that I have the database data, I need to store them in session variables which are a type of variables that we can use on all pages that has a session running in it.
          // This means i need to start a session here to be able to create the variables!
          session_start();
          // And now we create the session variables.
          $_SESSION['id'] = $row['idUsers'];
          $_SESSION['uid'] = $row['uidUsers'];
          $_SESSION['email'] = $row['emailUsers'];
          // Now the user is registered as logged in and we can now take them back to the front page 
          header("Location: ../index.php?login=success");
          exit();
        }
      }
      else {
        header("Location: ../homepage.php?login=wronguidpwd");
        exit();
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
