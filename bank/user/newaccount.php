<?php
include_once '../core/connection.php';

if (!$_SESSION) {
   
       
    header("Location: index.php");

 echo ('<h2>Please log in First</h2>');

    exit();
}

  $accountNumber= $_SESSION["id"] .rand(1111, 9999);
$acountName=$balance=$accounType="";
$nameError=$formError=$successMsg =$accountError=$balanceError="";
if (isset($_POST['addaccount']) && $_SERVER["REQUEST_METHOD"] === "POST") {

if (empty($_POST["acount-name"])) {
    $nameError = "Account name is required";
} else {
    $acountName = test_input($_POST["acount-name"]);
}
if (empty($_POST["account-type"])) {
    $accountError = "Account type is required";
} else {
    $accounType = test_input($_POST["account-type"]);
}
// if (empty($_POST["balance"])) {
//     $balanceError = "Enter a opening amount";
// } else if(($_POST["balance"]<5)){
//     $balanceError = "Minimum balance amout is 5";
// } else{
//     $balance = test_input($_POST["balance"]);
// }

 //checking if any field is empty
 if (empty($acountName) || empty($accounType) ) {
    $formError = "Please Complete the Form First";
} else {
    

    $sql = "INSERT INTO account (acount_name,balance, acount_number, acount_type, user_id, acount_status, created_at) VALUES (?,?,?,?,?,?,?)";
    $q = $pdo->prepare($sql)->execute([$acountName, $balance, $accountNumber, $accounType, $_SESSION['id'], "active", date("Y-m-d h:i:sa")]);
    if($q){
        $successMsg = "Form Submit Successfully. Redirecting Please wait";
        $acountName=$balance=$accounType="";
        header( "refresh:1;url=dashboard.php" );
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

   </body>
<?php include_once('nav.php')?>
<div class="div-center">


  <div class="content">


    <h3>Add a new Account!!</h3>
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
               <div class="form-group">
                  <label for="acount-name">Acount Name</label>
                  <input type="text" class="form-control" id="acount-name" placeholder="Account Name" name="acount-name" value="<?php echo $acountName?>">
                  <small class="text-danger"><?php echo $nameError ?></small>
               </div>
               <div class="form-group">
                  <label for="acount-number">Acount Number</label>
                  <input type="text" readonly class="form-control" id="acount-number" placeholder="Acount Number" name="acount-number" value="<?php echo $accountNumber ?>">
                 
               </div>
               <div class="form-group">
                  <label for="acount-type">Acount Type</label>
                  <select class="form-control"name="account-type" id="acount-type">
                      <option value="">Select an acount type</option>
                      <option value="checking">Checking</option>
                      <option value="Saving">Saving</option>
                      <option value="load">Loan</option>
                  </select>
                  <small class="text-danger"><?php echo $accountError ?></small>

               </div>
               
               
               
             
               <button type="submit" class="btn btn-primary" name="addaccount">Add Account</button>
               <br>
               <small class="text-success"><?php echo $successMsg ?></small>
               <small class="text-danger"><?php echo $formError ?></small>
               <hr />
               
            </form>

  </div>


  </span>
</div>



    <script src="../assets/script.js"></script>

</body>
</html>
