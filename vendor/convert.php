<?php
session_start();

if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

include("../config/connect.php");
include("../config/function.php");

$vendorName = $_SESSION['vendorName'];
$points = getVendorPoints($vendorName, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $balanceToAdd = $points;
    addBalanceToVendor($vendorName, $balanceToAdd, $conn);

    resetVendorPoints($vendorName, $conn);

    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert Points to Balance</title>
</head>

<body>
    <h2>Convert Points to Balance</h2>
    <form action="" method="post">
        <p>Are you sure you want to convert your points to balance?</p>
        <button type="submit">Convert</button>
    </form>
</body>

</html>