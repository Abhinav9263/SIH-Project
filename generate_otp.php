<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aadhar = $_POST['aadhar'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // Store OTP and other details in the database
    $stmt = $conn->prepare("INSERT INTO student_applications (aadhar, name, dob, gender, mobile, otp) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $aadhar, $name, $dob, $gender, $mobile, $otp);

    if ($stmt->execute()) {
        // Send OTP via SMS (You will need to integrate with an SMS gateway)
        // Example: send_sms($mobile, $otp);

        echo "OTP has been generated and sent to your mobile number.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>