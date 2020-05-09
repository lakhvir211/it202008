<?php
include_once '../core/connection.php';
 $id=$_GET['id'];
if (!$_SESSION) {
   
       
    header("Location: index.php");

 echo ('<h2>Please log in First</h2>');

    exit();
}
$account_type = "";
$id = $_GET['id'];
$type = $_GET['type'];
if ($type == "loan") {
    $account_type = "loan";
    //adding as -ve value in db

}
if ($type == "saving" || $type == "checking") {
    $account_type = "profit";

}
 include('amountCheck.php');
$balance="";
$formError=$successMsg =$balanceError=$accountError=$account="";
if (isset($_POST['worldTrasferAmount']) && $_SERVER["REQUEST_METHOD"] === "POST") {
print_r($_POST); 
if (empty($_POST["transferAmount"])) {
    $balanceError = "Enter the amount to Transfer";
} else if(($_POST["transferAmount"]<5)){
    $balanceError = "Minimum balance amount is 5";
} 
else if(($_POST["transferAmount"]>$total)){
    $balanceError = "Insufficent Balance ";
} 
else{
    $balance = test_input($_POST["transferAmount"]);
}
//accout number
if (empty($_POST["accountNumber"])) {
    $accountError = "Enter the account to Transfer";
} else if(!(strlen($_POST["accountNumber"]) == 12)){
    $accountError = "Enter A valid 12 digit Account number";
} 
else {
    $account = test_input($_POST["accountNumber"]);
}

 //checking if any field is empty
 if (empty($balance) || empty($account)) {
    $formError = "Please Complete the Form First";
} else {
    
//adding transiciton to world table

$query = "INSERT INTO world (source,dest,  amount,  time) VALUES (?,?,?,?)";
$r = $pdo->prepare($query)->execute([$_SESSION['id'],$account, $balance,  date("Y-m-d h:i:sa")]);

//addint transition to transiton table
    $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$id, 'transfer', $balance, 'world', date("Y-m-d h:i:sa")]);
  
    if($q){
        $successMsg = "withdraw success";
        $acountName=$balance=$accounType="";
        header('Location: ' . $_SERVER['REQUEST_URI']);

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


    <h3>Transfer from Your Account!!</h3>
    <hr />
    
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
                
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">
    <div class="form-group">
                  <label for="account">Enter Amounnt Number</label>
                  <input type="number"  class="form-control" id="account" placeholder="Acount Number" name="accountNumber" >
                  <small class="text-danger"><?php echo $accountError ?></small>

               </div>

               <div class="form-group">
                  <label for="Amount">Enter Amounnt to Transfer</label>
                  <input type="number"  class="form-control" id="Amount" placeholder="Transfer Amount" name="transferAmount" >
                  <small class="text-danger"><?php echo $balanceError ?></small>

               </div>
               
               
             
               <button type="submit" class="btn btn-danger" name="worldTrasferAmount">Transfer Amount</button>
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
