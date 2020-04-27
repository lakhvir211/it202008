<?php
include_once '../core/connection.php';

if (!$_SESSION) {
   
       
    header("Location: index.php");

 echo ('<h2>Please log in First</h2>');

    exit();
}

$stmt = $pdo->prepare("SELECT * FROM account WHERE user_id=?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetchAll();


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
    
<?php include_once 'nav.php'?>

<div class="container">
    <br><br>
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8">
                    <h2>Account <b>Details</b></h2>
                </div>
                <div class="col-sm-4">
                    <a href="newaccount.php" class="btn btn-info">Add new account</a>
                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
<th>index</th>
<th>Account Name</th>
<th>Account Number</th>
<th>Account Type</th>
<th>Action</th>
                </tr>
            </thead>
            <tbody>

                
<?php if (empty($user)) {
    echo "No Account created yet";} else{ $index = 0; 
    foreach($user as $u){
    ?>
<tr>
<td><?php echo ++$index?></td>
<td><?php echo $u['acount_name']?></td>
<td><?php echo $u['acount_number']?></td>
<td><?php echo $u['acount_type']?></td>
<td><a class="btn btn-sm btn-info "href="deposit.php?id=<?php echo $u['id'] ?>">Deposit</a>
<a class="btn btn-sm btn-info "href="withdraw.php?id=<?php echo $u['id'] ?>">withdraw</a>
<a class="btn btn-sm btn-info "href="intrnsfer.php?id=<?php echo $u['id'] ?>">In. Transfer</a></a>
<a class="btn btn-sm btn-info "href="extransfer.php?id=<?php echo $u['id'] ?>">Ex. Transfer</a>
<a class="btn btn-sm btn-info "href="hist.php?id=<?php echo $u['id']."&type=".$u['acount_type'] ?>">All Transitions</a>

</td>


    <?php }}?>
    
                </tr>
            </tbody>
        </table>
    </div>
</div>
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add New Account</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
               <div class="form-group">
                  <label for="acount-name">Acount Name</label>
                  <input type="text" class="form-control" id="acount-name" placeholder="Account Name" name="acount-name" value="<?php echo $acountName ?>">
                  <small class="text-danger"><?php echo $nameError ?></small>
               </div>
               <div class="form-group">
                  <label for="acount-number">Acount Number</label>
                  <input type="text" readonly class="form-control" id="acount-number" placeholder="Acount Number" name="acount-number" value="<?php echo $acountNumber ?>">

               </div>
               <div class="form-group">
                  <label for="acount-type">Acount Type</label>
                  <select class="form-control"name="account-type" id="acount-type">
                      <option value="">Select an acount type</option>
                      <option value="checking">Checking</option>
                      <option value="Saving">Saving</option>
                      <option value="load">Loan</option>
                  </select>

               </div>
               <div class="form-group">
                  <label for="balance">Opening Balance</label>
                  <input type="text" disabled class="form-control" id="balance" placeholder="Opening Balance" name="balance" value="<?php echo $balance ?>">

               </div>



               <button type="submit" class="btn btn-primary" name="addaccount">Add Account</button>
               <br>
               <small class="text-success"><?php echo $successMsg ?></small>
               <small class="text-danger"><?php echo $formError ?></small>
               <hr />
               <a  class="btn btn-link" href="index.php">Sign in</a>
               <a  class="btn btn-link" href="resetPass.php">Reset Password</a>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

</body>

</html>