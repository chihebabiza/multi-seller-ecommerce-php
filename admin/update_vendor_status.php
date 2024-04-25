<?php
// Start the session
session_start();

// Include database connection and functions
include("../config/connect.php");
include("../config/function.php");

// Call the function to update vendor status
updateVendorStatus($conn);

// Close database connection
mysqli_close($conn);
