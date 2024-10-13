<?php

$servername = "localhost";
$username = "appraisal_user";
$password = "your_strong_password";
$dbname = "appraisal";
$port = "5432"; 

try {
    $conn = new PDO("pgsql:host={$servername};port={$port};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection successful!"; // เพิ่มข้อความเพื่อแสดงว่าเชื่อมต่อสำเร็จ
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>