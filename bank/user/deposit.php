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
$formError=$successMsg =$balanceError="";
if (isset($_POST['addaccount']) && $_SERVER["REQUEST_METHOD"] === "POST") {

if (empty($_POST["balance"])) {
    $balanceError = "Enter the amount to deposit";
} else if(($_POST["balance"]<5)){
    $balanceError = "Minimum balance amout is 5";
} else{
    $balance = test_input($_POST["balance"]);
}

 //checking if any field is empty
 if (empty($balance) ) {
    $formError = "Please Complete the Form First";
} else {
    

    $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$id, 'deposit', $balance, 'internal', date("Y-m-d h:i:sa")]);
  
    if($q){
        $successMsg = "Form Submit Successfully. Redirecting Please wait";
        $acountName=$balance=$accounType="";
       // header( "refresh:1;url=dashboard.php" );
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


    <h3>Deposit Amount !!</h3>
   
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
               
    <hr />
    
    <form action="<?php echo   $_SERVER['REQUEST_URI']  ?>" method="post">
               
               <div class="form-group">
                  <label for="balance">Enter Amount to deposit</label>
                  <input type="number"  class="form-control" id="balance" placeholder="Opening Balance" name="balance" ">
                  <small class="text-danger"><?php echo $balanceError ?></small>

               </div>
               
               
             
               <button type="submit" class="btn btn-primary" name="addaccount">Add Amount</button>
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
