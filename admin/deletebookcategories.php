<?php
include ("includes/header.php");

$idtobeDeleted = $_GET["id"];
$query = "DELETE FROM `bookcategory` where category_id = $idtobeDeleted";
$result = mysqli_query($conn,$query);

if($result){
    echo "<script>
    alert('Category deleted successfully');
    window.location.href = 'allbookcategories.php'</script>";
}



include ("includes/footer.php");




?>