<?php
include "includes/header.php";

$idToBeDeleted = $_GET['id'] ;



$deleteQuery = "DELETE FROM competitions WHERE comp_id='$idToBeDeleted'";
$result = mysqli_query($conn, $deleteQuery);

if ($result) {
    echo "<script>alert('Competition deleted successfully');
    window.location.href='managecompetitions.php';</script>";
} else {
    echo "<script>alert('Failed to delete competition');
    window.location.href='managecompetitions.php';</script>";
}

include "includes/footer.php";
?>
