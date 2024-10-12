<?php

$servername = "localhost";
$username = "appraisal_user";
$password = "your_strong_password";
$dbname = "appraisal";
$port = "5432"; 

try {
    // Create a new PDO connection
    $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection successful!"; // Uncomment to test connection
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch form data if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["username"];

    // Prepare the SQL statement using PDO
    $sql = "SELECT * FROM employees WHERE firstname = :firstname";

    // Prepare and execute the statement securely to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check job_id and redirect accordingly
    if ($row) {
        if ($row["job_id"] == 3) {
            header("Location: chief-dashboard.php");
            exit();
        } else if ($row["job_id"] == 2) {
            header("Location: manager-dashboard.php");
            exit();
        } else if ($row["job_id"] == 1) {
            header("Location: officer-forms.php");
            exit();
        }
    } else {
        echo '<script>
                  alert("Incorrect input")
              </script>';
    }
}
?>
