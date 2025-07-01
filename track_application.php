<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $applicationNumber = $_POST['application-number'];

    $sql = "SELECT * FROM application_status WHERE application_number = '$applicationNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Status: " . $row["status_description"] . " - Last Updated: " . $row["last_updated"] . "<br>";
        }
    } else {
        echo "No application found with this number.";
    }

    $conn->close();
}
?>