<?php
include_once '../core/connection.php';
//if user already login redirct to main page
if ($_SESSION) {
    if ($_SESSION["bankLogin"] === true) {
            header("Location: dashboard.php");

        echo ('<h2>Alredy login Redirecting to Main Page </h2>');
    }
    exit();
}

$emailErr = "";
$passErr = "";
$email = "";
$pass = "";
$formerror = $successMsg = "";
if (isset($_POST['userLogin']) && $_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["user-email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["user-email"]);
    }
    if (empty($_POST["user-password"])) {
        $passErr = "Password is required";
    } else {
        $pass = test_input($_POST["user-password"]);
    }
    if (empty($email) || empty($pass)) {
        $formerror = "Please Complete the Form First";
    } else {

        $email = test_input($_POST["user-email"]);
        $stmt = $pdo->prepare("SELECT id, email, password, status FROM user WHERE email=?");
        $stmt->execute([$email]);
        
        $user = $stmt->fetch();
        //if user
        if ($user) {

            //if account is active
            if ($user['status'] === "active") {
                //if password is correct starting sessions
                if (password_verify($pass, $user['password'])) {
                    $_SESSION["bankLogin"] = true;
                    $_SESSION["id"] = $user['id'];
    header("Location: dashboard.php");

                    $successMsg = "Login success. Redirecting to main page in a few moments";
                   

                    // Success
                } else {
                    $formerror = "invalid email or password";
                }
            }
        } else {
            $formerror = "no record found";
        }
    }

}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/bootstrap.min.css">
<link rel="stylesheet" href="../assets/style.css">
<script src="../assets/jquery.min.js"></script>
<script src="../assets/bootstrap.min.js"></script>
    <title>Welcome to bank</title>
</head>
<body>






<div class="div-center">


  <div class="content">


    <h3>Welcome back Please login to continue!!</h3>
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="user-email" placeholder="Email" name="user-email">
        <small class="text-danger"><?php echo $emailErr ?></small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="user-password" placeholder="Password" name="user-password">
        <small class="text-danger"><?php echo $passErr ?></small>
      </div>
      <button type="submit" class="btn btn-primary" name="userLogin">Login</button>
      <br>
      <small class="text-success"><?php echo $successMsg ?></small>
      <small class="text-danger"><?php echo $formerror ?></small>
      <hr />
      <a  class="btn btn-link" href="signup.php">Signup</a>
     



    </form>

  </div>


  </span>
</div>



    <script src="../assets/script.js"></script>

</body>
</html>
