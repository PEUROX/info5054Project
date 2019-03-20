<?php
include 'conn.php';



$cate_id = $_POST['id'];

$sql = "DELETE FROM category_master WHERE category_id=$cate_id";

if ($conn->query($sql) === TRUE) {
    echo 1;
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

?>