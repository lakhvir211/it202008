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
$formError=$successMsg =$balanceError="";
if (isset($_POST['addaccount']) && $_SERVER["REQUEST_METHOD"] === "POST") {

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
    $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$id, 'withdraw', $balance, 'internal', date("Y-m-d h:i:sa")]);
  
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


    <h3>Withdraw from Your Account!!</h3>
    <hr />
    
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
                
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">
               
               <div class="form-group">
                  <label for="balance">Enter Amounnt to withdraw</label>
                  <input type="number"  class="form-control" id="balance" placeholder="Opening Balance" name="balance" ">
                  <small class="text-danger"><?php echo $balanceError ?></small>

               </div>
               
               
             
               <button type="submit" class="btn btn-danger" name="addaccount">Withdraw Amount</button>
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
