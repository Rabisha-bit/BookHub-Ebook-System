<?php
include ("includes/header.php");

$id = $_GET["id"];
$query = "DELETE FROM bestselling_books WHERE id=$id";
$result = mysqli_query($conn,$query);

if($result){
    echo "<script>
    alert('Book Deleted Successfully');
    window.location.href = 'allbestsellingbook.php'</script>";
}



include ("includes/footer.php");




?>