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
$account_id = $_GET['account_id'];
$user_id = $_GET['user_id'];


if ($type == "loan") {
    $account_type = "loan";
    //adding as -ve value in db

}
if ($type == "saving" || $type == "checking") {
    $account_type = "profit";

}
 include('amountCheck.php');
$formError=$successMsg =$balanceError="";
if (isset($_POST['transferBalance']) && $_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["balance"])) {
        $balanceError = "Enter the amount to deposit";
    } else if(($_POST["balance"]<5)){
        $balanceError = "Minimum balance amount is 5";
    } 
    else if(($_POST["balance"]>$total)){
        $balanceError = "Insufficent Balance ";
    } 
    else{
        $balance = test_input($_POST["balance"]);
    }
    
     //checking if any field is empty
     if (empty($balance) ) {
        $formError = "Please Complete the Form First";
    } else {
        
    
        $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
        $q = $pdo->prepare($sql)->execute([$user_id,$account_id, 'deposit', $balance, 'External', date("Y-m-d h:i:sa")]);
      
    }
        //Adding transfer record to current user
        $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
        $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$id, 'transfer', $balance, 'External', date("Y-m-d h:i:sa")]);
      
        if($q){
            $successMsg = "Transfer of fund Successfully. Redirecting Please wait";
            $acountName=$balance=$accounType="";
           // header( "refresh:1;url=dashboard.php" );
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


    <h3>Transfer Amount !!</h3>
   
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
               
    <hr />
    account_id=3&user_id=16&id=1&type=checking
    <form action="<?php echo  $_SERVER['REQUEST_URI'] ?>" method="post">
               
               <div class="form-group">
                  <label for="balance">Enter Amount to transfer</label>
                  <input type="number"  class="form-control" id="balance" placeholder="transfer Balance" name="balance">
                  <small class="text-danger"><?php echo $balanceError ?></small>

               </div>
               
               
             
               <button type="submit" class="btn btn-primary" name="transferBalance">Transfer Amount</button>
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
