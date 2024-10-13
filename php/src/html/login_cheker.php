<?php
session_start(); // Start the session at the beginning of the script

$servername = "localhost";
$username = "appraisal_user";
$password = "your_strong_password";
$dbname = "appraisal";
$port = "5432"; 

try {
    $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["username"];

    $sql = "SELECT * FROM employees WHERE firstname = :firstname";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Store the user's name in the session
        $_SESSION['user_firstname'] = $row['firstname'];

        if ($row["job_id"] == 1) {
            header("Location: chief-forms.php");
            exit();
        } else if ($row["job_id"] == 2) {
            header("Location: manager-dashboard.php");
            exit();
        } else if ($row["job_id"] == 3) {
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