<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gender = $_POST['gender'];
    $applicantName = $_POST['applicant-name'];
    $fatherName = $_POST['father-name'];
    $motherName = $_POST['mother-name'];
    $husbandName = $_POST['husband-name'];
    $mobileNo = $_POST['mobile-no'];
    $email = $_POST['email'];
    $state = $_POST['state'];
    $subDivision = $_POST['sub-division'];
    // Add other form fields here...

    // Insert into the database
    $sql = "INSERT INTO documents (user_id, document_name, file_path, upload_date)
            VALUES ('$userId', '$documentName', '$filePath', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>