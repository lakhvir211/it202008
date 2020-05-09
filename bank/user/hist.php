<?php
include_once '../core/connection.php';
$totalAmount = 0;
$total = 0;
$profitPer = 11;
//$date=date_create("2020-01-25 10:53:53am"); // or your date string

//if user already login redirct to main page
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

/*
if last month prfit is added
logic applied here is get date of last profit or loan instalment and
check difference with today if>=30 calculate profit or loan amount and insert it to database
if there is no last profit or loan date then calculate it from the very first day account open
 */

//if last profit or loan record if last profit / loan is 30 day old
$stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=? AND type =? ORDER BY id DESC LIMIT 1");
$stmt->execute([$id, $account_type]);
$row = $stmt->fetch();

if (empty($row)) {
    //if there is no record trying with account created Date to calculate if account is 30 day old
   
    $stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=? ORDER BY id ASC LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

}
if (!empty($row)) {
    // print_r($row);
    //calulating date differance
    $date_profit = $row['time'];
    $date = new DateTime($date_profit);

    $today = date('Y-m-d h:i:s a');

    $today = new DateTime($today);

    $interval = $date->diff($today);
    $int = $interval->format("%r%a");
//getting amount sum
include('amountCheck.php');
    

    if ($int >= 30) {
        //if more then one  month  insert profit in to db

        //calculating profit or loan amount
        $monthlyProfit = ($profitPer * $total) / 100;
        echo $monthlyProfit;

//inserting record in to database
        $sql = "INSERT INTO transitions (user_id,account_id, type, amount, transferType, time) VALUES (?,?,?,?,?,?)";
        $q = $pdo->prepare($sql)->execute([$_SESSION['id'], $id, $account_type, $monthlyProfit, 'internal', date("Y-m-d h:i:sa")]);
        //    refresh current page
        header('Location: ' . $_SERVER['REQUEST_URI']);

        //print_r($row);
    } else {
// if less then  1 month
        $stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=?");
        $stmt->execute([$id]);
        $user = $stmt->fetchAll();

    }
}
//filter by days
if (isset($_POST['filterbyDay']) && $_SERVER["REQUEST_METHOD"] === "POST") {
$day =$_POST['days'];

    $stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=? AND time >= CURDATE() - INTERVAL ? DAY");
    $stmt->execute([$id, $day]);
    $user = $stmt->fetchAll();

}

//filter by Transiction type
if (isset($_POST['filterbyType']) && $_SERVER["REQUEST_METHOD"] === "POST") {

    $filterType = $_POST['AcountType'];
    //if all refresh page
    if($filterType=="*"){
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
    $stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=? AND type=?");
    $stmt->execute([$id, $filterType]);
    $user = $stmt->fetchAll();
    

}
//fitle by date range:
if (isset($_POST['filterbyDate']) && $_SERVER["REQUEST_METHOD"] === "POST") {
//SELECT * FROM Product_sales 
// WHERE From_date between '2013-01-03'
// AND '2013-01-09'
$sdate = $_POST['startDate'];
$edate = $_POST['endDate'];
$stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=? AND time between ? AND ?");
    $stmt->execute([$id, $sdate, $edate]);
    $user = $stmt->fetchAll();
    

}

//exit;

// $stmt = $pdo->prepare("SELECT * FROM transitions WHERE account_id=?");
// $stmt->execute([$id]);
// $user = $stmt->fetchAll();
// //print_r($user);

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
                <div class="col-12"><h2>Filter Data</h2></div><br>
                <div class="col-12">

  <div class="form-row">
    <div class="col-3">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">

      <input type="number"  name="days"class="form-control" placeholder="x day record" >
      <input type="submit" name="filterbyDay"  value="Filter By Day">

</form>
    </div>
    <div class="col-3">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">

<select  class="form-control"name="AcountType" >
    <option  value="">Select By Type</option>
    <option value="*">All</option>
<option value="deposit">Debit</option>
<option value="withdraw">With Draw</option>
<option value="<?php echo $account_type ?>">Profit / Loan</option>
<option value="transfer">Transfer</option>

</select>
<input type="submit" name="filterbyType"  value="Filter By Type" class="">

</form>
    </div>
    <div class="col-6">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "&type=" . $type; ?>" method="post">

    <input type="date"  name="startDate"class="form-control" placeholder="start Date" >
    <input type="date"  name="endDate"class="form-control" placeholder="End Date" >

<input type="submit" name="filterbyDate"  value="Filter By Date Range" class="">

</form>
    </div>
  </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <h2>All Transition <b>Details</b></h2>
                </div>
                <div class="col-sm-4">
                <h3>Remaining Balance <b><?php echo $total ?></b></h3>
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
           <th>Type</th>
           <th>Transfer Type</th>
           <?php if (!$_POST) {?>
           <th>Remaining balance</th>
           <?php }?>
           </tr>
       </thead>
       <tbody>
           <?php if (empty($user)) {
    echo "No Record Found";
} else {
    $index = 0;
    $rAmount = 0;
    foreach ($user as $u) {
        ?>
           <tr>
               <td><?php echo ++$index ?></td>
               <td><?php echo $u['time'] ?></td>
               <td><?php echo $u['amount'] ?></td>
               <td><?php echo $u['type'] ?></td>
               <td><?php echo $u['transferType'] ?></td>
               <?php if (!$_POST) {?>
<td><?php

            if ($u['type'] == "profit" || $u['type'] == "deposit") {

                echo $rAmount = $rAmount + $u['amount'];
            }
            if ($u['type'] == "loan" || $u['type'] == "withdraw" || $u['type']=="transfer") {

                echo $rAmount = $rAmount - $u['amount'];
            }

            ?></td>

               <?php }}}?>
       </tbody>
   </table>
  </div>


  </span>
</div>



    <script src="../assets/script.js"></script>

</body>
</html>
