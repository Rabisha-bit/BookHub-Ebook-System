<?php


include("includes/header.php");
$idToBeDeleted = $_GET["id"];

$dbCurrentImageQuery = "Select book_icon FROM `kids_books_calendar` WHERE id = $idToBeDeleted";
$imageData = mysqli_query($conn, $dbCurrentImageQuery);
$imageData = mysqli_fetch_assoc($imageData);
$currentImageName = $imageData["book_icon"];



$oldimagePath = "calendaricons/" . $currentImageName;
if (file_exists($oldimagePath)) {
    unlink($oldimagePath);
}


$deletebookQuery = "DELETE FROM `kids_books_calendar` WHERE id = $idToBeDeleted";
$result = mysqli_query($conn, $deletebookQuery);

if ($result) {
    echo "<script>window.location.href = 'managecalendars.php'</script>";

}

?>