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

  $stmt = $pdo->prepare("SELECT * FROM account WHERE user_id=? AND acount_status = ? ");
  $stmt->execute([$_SESSION['id'],'active']);
  $user = $stmt->fetchAll();

  

$balance=$account_num="";
$formError=$successMsg =$balanceError=$accountError="";
if (isset($_POST['addaccount']) && $_SERVER["REQUEST_METHOD"] === "POST") {
if(empty($_POST['account-type'])){
    $accountError= "Enter Account Number";
}else{
    $account = test_input($_POST["account-type"]);
}
if (empty($_POST["balance"])) {
    $balanceError = "Enter the amount to deposit";
} else if(($_POST["balance"]<5)){
    $balanceError = "Minimum balance amout is 5";
}
else if(($_POST["balance"]>$total)){
    $balanceError = "Insufficent Balance ";
} 
else{
    $balance = test_input($_POST["balance"]);
}

 //checking if any field is empty
 if (empty($balance) ||empty($account) ) {
    $formError = "Please Complete the Form First";
} else {
    //transfer to
    $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$account, 'deposit', $balance, 'internal', date("Y-m-d h:i:sa")]);
//transfer from
$sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$id, 'transfer', $balance, 'internal', date("Y-m-d h:i:sa")]);
  

  
    if($q){
        $successMsg = "Transfer of fund Successfully. Redirecting Please wait";
        $acountName=$balance=$accounType="";
       // header( "refresh:1;url=dashboard.php" );
       sleep(1);
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


    <h4>internal Transfer Amount !!</h4>
    <hr />
    
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
              
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">
    <div class="form-group">
                  <label for="acount-type">Acount Type</label>
                  <select class="form-control"name="account-type" id="acount-type">
                      <option value="">Select an acount type</option>
                      <?php 

                      foreach($user as $u){
                          //if current account dont show it
                        if($id !== $u['id'] ){
                          ?>
                      
<option value="<?php echo $u['id'] ?>"><?php echo $u['acount_name']?></option>
<?php
                 }     }
                      ?>
                  </select>
                  <small class="text-danger"><?php echo $accountError ?></small>

               
               <div class="form-group">
                  <label for="balance">Enter Amount to transfer</label>
                  <input type="number"  class="form-control" id="balance" placeholder="Amount To Transfer" name="balance" >
                  <small class="text-danger"><?php echo $balanceError ?></small>

               </div>
               
               
             
               <button type="submit" class="btn btn-primary" name="addaccount">Transfer Amount</button>
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
