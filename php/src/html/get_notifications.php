<?php
include "connection.php";
session_start();
$currentUserId = $_SESSION['currentUserId'];
if (isset($currentUserId)) {

    $sql = "SELECT detail,feedback_date,subjects FROM feedback WHERE e_id = :currentUserId ORDER BY feedback_date";
    $query = $conn->prepare($sql);
    $query->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);
    $query->execute();


    $notifications = $query->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode(['notifications' => $notifications]);
} else {
    echo json_encode(['error' => 'User not authenticated']);
}
?>