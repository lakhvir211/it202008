<?php
include_once '../core/connection.php';
$user = '';
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

$balance=$account_num="";
$formError=$successMsg =$balanceError=$accountError="";
if (isset($_POST['searcaccount']) && $_SERVER["REQUEST_METHOD"] === "POST") {


 //checking if any field is empty
 if (empty($_POST['account-num']) && empty($_POST['userName']) ) {
    $formError = "Either Add Account Number or user name to find an account";
} else {
//if account exist
$stmt = $pdo->prepare("SELECT *  FROM account WHERE  right(acount_number,6)= ?  or acount_name=? AND  acount_status =? ");
$stmt->execute([$_POST['account-num'],$_POST['userName'], 'active' ]);

$user = $stmt->fetchAll();

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

<?php if(empty($user)){?>
  <div class="content">


    <h4>External Transfer Amount!!</h4>

                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
               
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">
    <div class="form-group">
                  <label for="balance"> Account number to Transfer</label>
                  <input type="number"  class="form-control" id="balance-transfer" placeholder=" Enter  last 6 digit of Account number" name="account-num" >
                  

               </div>
               
               <div class="form-group">
                  <label for="balance">or Enter user name to transfer</label>
                  <input type="text"  class="form-control" id="balance" placeholder="user name" name="userName" >
                  

               </div>
               
               
             
               <button type="submit" class="btn btn-primary" name="searcaccount">Search</button>
               <br>
               <small class="text-success"><?php echo $successMsg ?></small>
               <small class="text-danger"><?php echo $formError ?></small>
               <hr />
               
            </form>

  </div>
<?php }?>
 
  </span>
</div>
<div class="row">
<?php if(!empty($user)){
    
    ?>

<table class="table table-bordered">
            <thead>
                <tr>

<th>Account Name</th>
<th>Account Number</th>
<th>Tranfer to this Account</th>

                </tr>
            </thead>
            <tbody>

                
<?php foreach($user as $u){?>
    <tr>
<td><?php echo $u['acount_name']?></td>
<td><?php echo $u['acount_number']?></td>
<?php if($u['acount_status']==='active'){?>
<td><a href="transfer.php?account_id=<?php echo $u['id']."&user_id=".$u["user_id"]. "&id=" . $id. "&type=" . $type;?>">Transfer to This Account</a></td>
<?php }else { echo"<td>Acount is disable</td>"; } ?>
   
    
</tr>
<?php
}
?>
            </tbody>
        </table>
        <?php
}
?>
</div>


    <script src="../assets/script.js"></script>

</body>
</html>
