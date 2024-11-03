<?php
include 'db_connect.php';

if (isset($_POST['save'])) {
    $dynamic_data = json_encode($_POST['dynamic_data']);

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE phonebook SET data='$dynamic_data' WHERE id='$id'";
    } else {
        $sql = "INSERT INTO phonebook (data) VALUES ('$dynamic_data')";
    }

    if ($conn->query($sql)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM phonebook WHERE id='$id'";
    if ($conn->query($sql)) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
