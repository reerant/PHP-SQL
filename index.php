<?php
// Starts the session
session_start();

//Checks if there is already valid session id, and if true directs to todos-page.
if (isset($_SESSION['id'])) {
  header("Location:todos.php");
}


// Includes database connection details
include 'DBconn.php';

//checks if login form's email and password are not empty, if true continues. 
if (!empty($_POST['loginEmail']) && !empty($_POST['loginPassword'])) {

  //email and password details are send from the login form.
  //FILTER_SANITIZE_STRING  removes HTML tags 
  $email = filter_var($_POST['loginEmail'], FILTER_SANITIZE_STRING);
  $pwd = filter_var($_POST['loginPassword'], FILTER_SANITIZE_STRING);

  //makes sql query with prepared statements 
  $sql = $conn->prepare("SELECT * FROM user WHERE email=?");
  $sql->bind_param("s", $email);
  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $userID = $row['userID'];
    $email = $row['email'];
    $password = $row['password'];
    $fname = $row['fname'];
    $lname = $row['lname'];

    //creates session variables
    if (password_verify($pwd, $password)) {
      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['id'] = $userID;

      $message = '';
      header("Location:todos.php");
    } else {
      $message = 'Invalid username or password.';
    }
  } else {
    $message = 'Invalid username or password.';
  }
}

?>

<?php
// Include DB connection details
include 'DBconn.php';

//if user clicks register-button code below will be executed.
//takes string values from the form and places them into variables that are used with sql query.
if (isset($_POST['registerButton'])) {

  //FILTER_SANITIZE_STRING  removes HTML tags 
  $fname = filter_var($_POST['regFname'], FILTER_SANITIZE_STRING);
  $lname = filter_var($_POST['regLname'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['regEmail'], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST['regPassword'], FILTER_SANITIZE_STRING);

  //checks if given email is already in the database. If true, shows message to user. 
  //if not, continues to insert data into DB.
  //makes sql query with prepared statements 
  $sql = $conn->prepare("SELECT * FROM user WHERE email=?");
  $sql->bind_param("s", $email);
  $sql->execute();
  $result = $sql->get_result();

  if ($result->num_rows >= 1) {
    $regMessage = "Registration not successful. This email is already taken. Please try to register again with another email.";
  } else {
    $regMessage = '';
    //password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //makes sql query with prepared statements  
    $sql = $conn->prepare("INSERT INTO user(fname,lname,email,password) VALUES(?, ?, ?, ?)");
    $sql->bind_param("ssss", $fname, $lname, $email, $hashed_password);
    $status = $sql->execute();

    //if inserting data into the DB succeeds, user is directed back to the login page.
    //if not, an error message is shown.
    if ($status === true) {
      header("Location: index.php");
    } else {
      trigger_error("Registration not successful");
    }

    $conn->close();
  }
}
?>


<!--including html head section and jumbotron -->
<?php include 'head.php'; ?>

<!--HTML/ page structure  -->
<div id="welcome" style="margin-bottom: 20px;">
  <div class="row">
    <div class="col-sm-12">
      <h2 style="color:#656870">Welcome to My ToDos</h2>
      <p>Sign in with your email and password.</p>
    </div>
  </div>
  <!-- validateLogin checks if there are any empty fields in the form when submitting -->
  <form action="index.php" name="loginForm" method="post" id="loginForm" onsubmit="return validateLogin()">
    <div class="form-group">
      <label for="loginEmail" class="col-form-label">Email:</label>
      <input type="text" class="form-control" id="loginEmail" name="loginEmail">
    </div>
    <div class="form-group">
      <label for="loginPassword" class="col-form-label">Password:</label>
      <input type="password" class="form-control" id="loginPassword" name="loginPassword">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-secondary" id="loginButton" name="loginButton">Login</button>
    </div>
    <br>
    <!-- shows message if username or password is invalid when trying to login. -->
    <?php if (!empty($message)) : ?>
      <p class="loginMessage"><?= $message ?></p>
    <?php endif; ?>

    <!-- shows message if email is already taken. -->
    <?php if (!empty($regMessage)) : ?>
      <p class="registerMessage"><?= $regMessage ?></p>
    <?php endif; ?>

    <br>
    <p>If you do not have an account yet click on "Register" to create one. </p>
    <div class="form-group">
      <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#register">Register</button>
    </div>
  </form>
</div>

<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="registerTitle">Create new account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- validateRegister checks if there are any empty fields in the form when submitting -->
        <form action="index.php" name="registerForm" method="post" id="registerForm" onsubmit="return validateRegister()">

          <div class="form-group">
            <label for="regFname">First name</label>
            <input type="text" class="form-control" id="regFname" name="regFname">
          </div>

          <div class="form-group">
            <label for="regLname">Last name</label>
            <input type="text" class="form-control" id="regLname" name="regLname">
          </div>

          <div class="form-group">
            <label for="regEmail">Email</label>
            <input type="email" class="form-control" id="regEmail" name="regEmail">
          </div>

          <div class="form-group">
            <label for="regPassword">Password</label>
            <input type="password" class="form-control" id="regPassword" name="regPassword" aria-describedby="passwordHelpBlock" pattern=".{8,}" title="Password must contain eight or more characters"><small id="passwordHelpBlock" class="form-text text-muted">
              Your password must contain eight or more characters.
            </small>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-secondary" name="registerButton">Create</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>

        </form>

      </div>

    </div>
  </div>
</div>
<!--includes footer info -->
<?php include 'footer.php'; ?>