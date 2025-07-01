<?php
// verify_otp.php
include 'application_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aadhar_no = $_POST['aadhar'];
    $otp = $_POST['otp'];

    // Check if OTP is correct and not expired
    $stmt = $conn->prepare("SELECT id FROM students WHERE aadhar_no = ? AND otp = ? AND otp_expiry >= NOW()");
    $stmt->bind_param("ss", $aadhar_no, $otp);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "OTP verified successfully.";
        // Proceed with the registration process
    } else {
        echo "Invalid or expired OTP.";
    }
    $stmt->close();
}
?>