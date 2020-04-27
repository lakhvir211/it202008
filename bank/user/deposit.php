<?php
include_once '../core/connection.php';
 $id=$_GET['id'];
if (!$_SESSION) {
   
       
    header("Location: index.php");

 echo ('<h2>Please log in First</h2>');

    exit();
}

 
$balance="";
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


    <h3>Add a new Account!!</h3>
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$id; ?>" method="post">
               
               <div class="form-group">
                  <label for="balance">Enter Amounnt to deposit</label>
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
