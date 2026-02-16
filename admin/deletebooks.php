<?php


include("includes/header.php");
$idToBeDeleted = $_GET["id"];

$dbCurrentImageQuery = "Select book_cover from book where book_id = $idToBeDeleted";
$imageData = mysqli_query($conn, $dbCurrentImageQuery);
$imageData = mysqli_fetch_assoc($imageData);
$currentImageName = $imageData["book_cover"];

$dbcurrentpdfQuery = "Select pdf_file from book where book_id = $idToBeDeleted";
$pdfData = mysqli_query($conn, $dbcurrentpdfQuery);
$pdfData = mysqli_fetch_assoc($pdfData);
$currentpdfname = $pdfData["pdf_file"];

$oldimagePath = "bookimages/" . $currentImageName;
if (file_exists($oldimagePath)) {
    unlink($oldimagePath);
}
$oldimagePath = "pdf/" . $currentpdfname;
if (file_exists($oldimagePath)) {
    unlink($oldimagePath);
}


$deletebookQuery = "Delete from book where book_id = $idToBeDeleted";
$result = mysqli_query($conn, $deletebookQuery);

if ($result) {
    echo "<script>window.location.href = 'allbooks.php'</script>";

}

?>