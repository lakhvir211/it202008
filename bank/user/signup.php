<?php
   include_once '../core/connection.php';
   $emailErr = $cardErr = $passErr = $addressErr = $nameError = $contactError = $successMsg = $formerror = "";
   
   $name = $pass = $email = $contact = $cardNum = $address = "";
   
   if (isset($_POST['userLogin']) && $_SERVER["REQUEST_METHOD"] === "POST") {
      
     
      //name
      if (empty($_POST["user-name"])) {
          $nameError = "Name is required";
   
      } else {
          $name = test_input($_POST["user-name"]);
      }
       // email validation
       if (empty($_POST["user-email"])){
        $emailErr = "Email is required";
    } 
    else{
        $email = test_input($_POST["user-email"]);
        // if user already exists
        $stmt = $pdo->prepare("SELECT email FROM user WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if($user){
            $emailErr = "Email already in use";
        }
        else{
            $emailErr="";
        }
    }
      
   // mobile number
      if (empty($_POST["user-mobile"])) {
          $contactError = "Mobile number is required";
      } else {
          $contact = test_input($_POST["user-mobile"]);
      }
   
  
      // password validation
      if (empty($_POST["user-password"])) {
          $passErr = "Password is required";
      } else {
          $pass = test_input($_POST["user-password"]);
          $password = password_hash($pass, PASSWORD_DEFAULT);
      }
   
      //card number
      if (empty($_POST["user-card"])) {
          $cardErr = "Card Number is required";
      } else if (strlen($_POST["user-card"]) <= 14) {
          $cardErr = "Minimum length is 14";
      } else {
          $cardNum = test_input($_POST["user-card"]);
      }
      //address
      if (empty($_POST["user-address"])) {
          $addressErr = "Address is required";
      } else {
          $address = test_input($_POST["user-address"]);
      }
      //checking if any field is empty
      if (empty($name) || empty($pass) || empty($email) || empty($cardNum) || empty($contact) || empty($address)) {
          $formerror = "Please Complete the Form First";
      } else {
          
   
          $sql = "INSERT INTO user (name, mobile, email,password,address,id_card, created_at, status) VALUES (?,?,?,?,?,?,?,?)";
          $q = $pdo->prepare($sql)->execute([$name, $contact, $email, $password, $address, $cardNum, date("Y-m-d h:i:sa"), "active"]);
            $name = $pass = $email = $contact = $cardNum = $address = "";
              header("Location: index.php");

          $successMsg = "Form Submit Successfully";
          exit;
        
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
      <div class="div-center-signup">
         <div class="content">
            <h3>Welcome back Please Signup to enjoy online banking!!</h3>
            <hr />
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
               <div class="form-group">
                  <label for="user-name">Name</label>
                  <input type="text" class="form-control" id="user-name" placeholder="Name" name="user-name" value="<?php echo $name ?>">
                  <small class="text-danger"><?php echo $nameError ?></small>
               </div>
               <div class="form-group">
                  <label for="user-mobile">Mobile</label>
                  <input type="text" class="form-control" id="user-mobile" placeholder="Mobile" name="user-mobile" value="<?php echo $contact ?>">
                  <small class="text-danger"><?php echo $contactError ?></small>
               </div>
               <div class="form-group">
                  <label for="user-email">Email address</label>
                  <input type="email" class="form-control" id="user-email" placeholder="Email" name="user-email" value="<?php echo $email ?>">
                  <small class="text-danger"><?php echo $emailErr ?></small>
               </div>
               <div class="form-group">
                  <label for="user-password">Password</label>
                  <input type="password" class="form-control" id="user-password" placeholder="Password" name="user-password">
                  <small class="text-danger"><?php echo $passErr ?></small>
               </div>
               <div class="form-group">
                  <label for="user-card">Card Number</label>
                  <input type="text" class="form-control" id="user-card" placeholder="card Number" name="user-card" value="<?php echo $cardNum ?>">
                  <small class="text-danger"><?php echo $cardErr ?></small>
               </div>
               <div class="form-group">
                  <label for="user-address">Address</label>
                  <input type="text" class="form-control" id="user-address" placeholder="Address" name="user-address"value="<?php echo $address ?>">
                  <small class="text-danger"><?php echo $addressErr ?></small>
               </div>
               <button type="submit" class="btn btn-primary" name="userLogin">signup</button>
               <br>
               <small class="text-success"><?php echo $successMsg ?></small>
               <small class="text-danger"><?php echo $formerror ?></small>
               <hr />
               <a  class="btn btn-link" href="index.php">Sign in</a>
              
            </form>
         </div>
         </span>
      </div>
      </div>
      <script src="../assets/script.js"></script>
   </body>
</html>