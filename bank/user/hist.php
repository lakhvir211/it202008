<?php
include_once '../core/connection.php';
$totalAmount = 0;
$profitPer = 11;
//$date=date_create("2020-01-25 10:53:53am"); // or your date string


//if user already login redirct to main page
if (!$_SESSION) {
   
       
    header("Location: index.php");

 echo ('<h2>Please log in First</h2>');

    exit();
}


$id = $_GET['id'];
$type = $_GET['type'];
//start date
$stmt = $pdo->prepare("SELECT time FROM transitions WHERE account_id=? ORDER BY id ASC");
$stmt->execute([$id]);
$date = $stmt->fetch();
$s = $date['time'];
$date_profit = $s;
$date = new DateTime($date_profit);

$stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=?");
$stmt->execute([$id]);
$user = $stmt->fetchAll();
//print_r($user);

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
                    <h2>All Transition <b>Details</b></h2>
                </div>
                <div class="col-sm-4">

                    <!-- <button type="button" class="btn btn-info add-new" data-backdrop="static" data-keyboard="false"  data-toggle="modal" data-target="#myModal"></i> Add New</button> -->
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
       <thead><tr>
           <th>index</th>
           <th>Date and Time</th>
           <th>Amount</th>
           <th>Transfer Type</th>
           <th>Remaining balance</th>
           </tr>
       </thead>
       <tbody>
           <?php if (empty($user)) {
    echo "No Record Found";
} else {
    $index = 0;
    foreach ($user as $u) {
        ?>
           <tr>
               <td><?php echo ++$index ?></td>
               <td><?php echo $u['time'] ?></td>
               <td><?php echo $u['amount'] ?></td>
               <td><?php echo $u['type'] ?></td>
               <td>

               <?php
//if deposit add to amount
        if ($u['type'] === 'deposit') {
            $totalAmount = $totalAmount + $u['amount'];
            echo $totalAmount;
        }
        //if withdraw remove from total amount
        if ($u['type'] === 'withdraw' || $u['type'] === 'transfer') {
            $totalAmount = $totalAmount - $u['amount'];
            echo $totalAmount;
        }
      

        ?>
               </td>

           </tr>
           <?php
           //if one month completed calculating profit on total amount

$today = $u['time'];
$today = new DateTime($today);


$interval = $date->diff($today);
$int = $interval->format("%r%a");
if ($int >= 30) {
    
//$date =  date('Y-m-d', strtotime($date. ' + 30 days'));
$monthlyProfit = ($profitPer*$totalAmount)/100;
if($type === "Loan"){
    $totalAmount = $totalAmount-$monthlyProfit;
    $text = "Loan Instalment";
}else{
    $totalAmount = $totalAmount+$monthlyProfit;
    echo $totalAmount;
    $text = "monthly Profit";
}

$date= date_add($date,date_interval_create_from_date_string("30 days"));// add number of days 
 ?>
 <tr class="alert-success"><td><?php echo ++$index?></td>
 <td><?php echo date_format($date,"Y-m-d H:i:s a"); ?></td>
 <td><?php echo $monthlyProfit;?></td>
 <td><?php echo $text;?></td>
 <td><?php echo $totalAmount?></td></tr>



               <?php }}}?>
       </tbody>
   </table>
  </div>


  </span>
</div>



    <script src="../assets/script.js"></script>

</body>
</html>
