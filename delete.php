<?php
require_once('./connection.php');



if (isset($_POST['action']) && $_POST['action'] == 'Kustuta') {
    $id = $_POST['id'];
    
    $stmt = $pdo->prepare('UPDATE books SET is_deleted = 1 WHERE id = :id');
    $stmt->execute([':id' => $id]);
    header("Location: ./index.php");
}

?>

