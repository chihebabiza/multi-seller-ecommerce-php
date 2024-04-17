<?php
session_start();

include("../config/connect.php");
include("../config/function.php");

if (!isset($_SESSION['vendorName'])) {
    header("Location: ../client/login.php");
    exit();
}

$name = $_SESSION['vendorName'];
$email = isset($_SESSION['vendorEmail']) ? $_SESSION['vendorEmail'] : '';

if (isset($_POST['updateProfile'])) {
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    updateProfile($_SESSION['vendor_id'], $newName, $newEmail, $newPassword);
    // Update session variables with new name and email
    $_SESSION['vendorName'] = $newName;
    $_SESSION['vendorEmail'] = $newEmail;
    header("Location: vendor.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <br>
    <form style="text-align: center;" method="post" action="">
        <h3>Welcome, <?php echo $_SESSION['vendorName']; ?></h3>
        <h1>Edit Profile</h1>
        <label>Name:</label>
        <input type="text" name="newName" value="<?php echo $name; ?>"><br><br>
        <label>Email:</label>
        <input type="email" name="newEmail" value="<?php echo $email; ?>"><br><br>
        <label>New Password:</label>
        <input type="password" name="newPassword"><br><br>
        <input type="submit" name="updateProfile" value="Update Profile">
    </form>
</body>

</html>