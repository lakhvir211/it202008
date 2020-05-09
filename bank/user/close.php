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

//close account
if (isset($_POST['closeAccount']) && $_SERVER["REQUEST_METHOD"] === "POST") {


    

    $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
    $q = $pdo->prepare($sql)->execute([$_SESSION['id'],$id, 'withdraw', $balance, 'internal', date("Y-m-d h:i:sa")]);
  
    $sql = "UPDATE account SET acount_status=? WHERE id=?";
    $stmt= $pdo->prepare($sql);
   $q= $stmt->execute(["deactivate", $id]);
if($q){
    header("Location: dashboard.php");
}
    
    
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


    <h3>Close Account!!</h3>
    <hr />
    
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
                
                <?php 
if($total>0){

    if($account_type==="profit"){
        echo"<h2>Account balance should b 0 before closing this account</h2>";
    }
    if($account_type==="loan"){
        echo"<h2>Clear the Loan before closing this account</h2>";
    }
}
else{
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">
               
    <div class="form-group">
       <label for="balance">Are Your Sure You want to Disable your Account</label>
       

    </div>
    
    
  
    <button type="submit" class="btn btn-danger" name="closeAccount">Proceed</button>
    <br>
    <small class="text-success"><?php echo $successMsg ?></small>
    <small class="text-danger"><?php echo $formError ?></small>
    <hr />
    
 </form>
<?php
}

?>
   

  </div>


  </span>
</div>



    <script src="../assets/script.js"></script>

</body>
</html>
