<?php
//getting sum of balance
$total = 0;
    //total deposit
    $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM transitions WHERE account_id=? AND type=?");
    $stmt->execute([$id, "deposit"]);

    $row = $stmt->fetch();
    $Deposit = $row['total'];

    //total withdraw
    $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM transitions WHERE account_id=? AND type=?");
    $stmt->execute([$id, "withdraw"]);

    $row = $stmt->fetch();
    $withdraw = $row['total'];
    //total transfer
    //total withdraw
    $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM transitions WHERE account_id=? AND type=?");
    $stmt->execute([$id, "transfer"]);

    $row = $stmt->fetch();
    $trans = $row['total'];

    //total profit or loan
    $stmt = $pdo->prepare("SELECT SUM(amount) as total FROM transitions WHERE account_id=? AND type=?");
    $stmt->execute([$id, $account_type]);

    $row = $stmt->fetch();
    $others = $row['total'];

    // total amout in account
    if ($type == "loan") {
        //removing loan
        $total = $Deposit - $withdraw - $others-$trans;
        //adding as -ve value in db

    }
    if ($type == "saving" || $type == "checking") {
        //adding profit
        $total = $Deposit - $withdraw + $others-$trans;
        

    }

    ?>