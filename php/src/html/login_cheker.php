<?php
session_start(); // Start the session at the beginning of the script

$servername = "db";
$username = "appraisal_user";
$password = "your_strong_password";
$dbname = "appraisal";
$port = "5432"; 

try {
    // Establish database connection
    $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["username"];  // Get the username from POST data

    // Query to find the employee by their firstname
    $sql = "SELECT * FROM employees WHERE firstname = :firstname";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Store the user's firstname and ID in the session
        $_SESSION['user_firstname'] = $row['firstname'];
        $_SESSION['currentUserId'] = $row['e_id']; // Set currentUserId from the employee's ID

        // Redirect based on the employee's job_id
        if ($row["job_id"] == 1) { // Chief
            header("Location: Chief/chief-dashboard.php");
            exit();
        } else if ($row["job_id"] == 2) { // Manager
            header("Location: Manager/manager-dashboard.php");
            exit();
        } else if ($row["job_id"] == 3) { // Officer
            header("Location: Officer/officer-forms.php");
            exit();
        }
    } else {
        // If the user is not found, alert the user
        echo '<script>
                  alert("Incorrect input")
              </script>';
    }
}
?>
