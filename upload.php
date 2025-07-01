<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "application_db"; // Ensure this matches your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect applicant details from the form
$applicant_name = $_POST['applicant-name'];
$father_name = $_POST['father-name'];
$mother_name = $_POST['mother-name'];
$husband_name = $_POST['husband-name'] ?? null; // Optional
$mobile_no = $_POST['mobile-no'];
$email = $_POST['email'];
$state = $_POST['state'];
$sub_division = $_POST['sub-division'];

// Store applicant details in the users table
$sql = "INSERT INTO users (name, email, mobile_no, father_name, mother_name, husband_name, state, sub_division) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $applicant_name, $email, $mobile_no, $father_name, $mother_name, $husband_name, $state, $sub_division);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id; // Get the ID of the inserted user
} else {
    die("Error: " . $stmt->error);
}

// Handle file uploads
if (!empty($_FILES['pdf_files']['name'][0])) {
    foreach ($_FILES['pdf_files']['name'] as $key => $pdf_name) {
        $pdf_tmp_name = $_FILES['pdf_files']['tmp_name'][$key];
        $pdf_size = $_FILES['pdf_files']['size'][$key];
        $pdf_error = $_FILES['pdf_files']['error'][$key];
        $pdf_ext = strtolower(pathinfo($pdf_name, PATHINFO_EXTENSION));

        // Check for upload errors
        if ($pdf_error === 0) {
            if ($pdf_size <= 5000000) { // 5MB max size
                $pdf_data = file_get_contents($pdf_tmp_name);

                // Store file info in the database
                $sql = "INSERT INTO documents (user_id, document_name, file_data, file_type, upload_date) VALUES (?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isss", $user_id, $pdf_name, $pdf_data, $pdf_ext);

                if (!$stmt->execute()) {
                    echo "Error: " . $stmt->error;
                }
            } else {
                echo "File $pdf_name is too large.";
            }
        } else {
            echo "Error uploading file $pdf_name.";
        }
    }
} else {
    echo "No PDF files selected.";
}

echo "Application submitted successfully.";
$stmt->close();
$conn->close();
?>