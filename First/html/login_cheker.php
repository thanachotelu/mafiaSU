<?php
include "connection.php"

/*
อ่านก่อนเด้อ

chat gen ให้

ยังไม่รู้ว่าจะใช้ได้ไหมนะ
*/

try {
    $conn = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobPosition = $_POST['jobPosition'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example: Checking credentials based on job position
    $sql = "SELECT * FROM users WHERE username = :username AND job_position = :jobPosition";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':jobPosition', $jobPosition);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists and password matches
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['jobPosition'] = $user['job_position'];

        // Redirect based on job position
        if ($jobPosition == 'employees') {
            header("Location: employee_dashboard.php");
        } elseif ($jobPosition == 'hr') {
            header("Location: hr_dashboard.php");
        } elseif ($jobPosition == 'ceo') {
            header("Location: ceo_dashboard.php");
        }
        exit();
    } else {
        // Invalid login
        echo "Invalid username or password.";
    }
}
?>
