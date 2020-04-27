<?php
include_once '../core/connection.php';

if (!$_SESSION) {
   
       
    header("Location: index.php");

 echo ('<h2>Please log in First</h2>');

    exit();
}

$oldPassErr = "";
$passErr = $formerror=$successMsg="";
$oldPass = "";
$pass="";
if (isset($_POST['resetpass']) && $_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["old-password"])) {
        $oldPassErr = "Please Enter Old Password";
    } else {
        $oldPass = test_input($_POST["old-password"]);
    }
    if (empty($_POST["new-password"])) {
        $passErr = "Password is required";
    } else {
        $pass = test_input($_POST["new-password"]);
    }
    echo $oldPass;
    echo $pass;
    if(empty($oldPass)|| empty($pass)){
      $formerror = "Please Complete the Form First";

    }else{
      $id= $_SESSION['id'];
      $stmt = $pdo->prepare("SELECT password FROM user WHERE id=?");
      $stmt->execute([$id]);
      $user = $stmt->fetch();
      //if user
      if ($user) {

          //if account is active
         
              //if password is correct starting sessions
              if (password_verify($oldPass, $user['password'])) {
                $sql = "UPDATE user SET password=? WHERE id=?";
                $stmt= $pdo->prepare($sql);
               $q= $stmt->execute([$pass, $id]);
if($q){
  $successMsg="Password change success. Loging out and redirecting to main page";
  unset($_SESSION["bankLogin"]);
unset($_SESSION["id"]);
    header("index.php");
	exit;


}
                  // Success
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





<?php include_once 'nav.php'?>

<div class="div-center">


  <div class="content">


    <h3>Reset Password</h3>
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group">
        <label for="old-password">Old Password</label>
        <input type="password" class="form-control" id="old-password" placeholder="Old Password" name="old-password">
        <small class="text-danger"><?php echo $oldPassErr ?></small>

      </div>
      <div class="form-group">
        <label for="new-password">New Password</label>
        <input type="password" class="form-control" id="new-password" placeholder="New Password" name="new-password">
        <small class="text-danger"><?php echo $passErr ?></small>

      </div>
      <button type="submit" class="btn btn-primary" name="resetpass">Reset Password</button>
      <br>
      <small class="text-success"><?php echo $successMsg ?></small>
      <small class="text-danger"><?php echo $formerror ?></small>
      <hr />
      
      

    </form>

  </div>


  </span>
</div>


    </div>
    <script src="../assets/script.js"></script>

</body>
</html>
