<?php
session_start();
include 'database/config.php';

$bookId = $_POST["book_id"];
$format = $_POST["format"];  
$price = $_POST["price"];
$type = $_POST["type"];      

// Book ki details lao
$query = mysqli_query($conn,"SELECT * FROM book WHERE book_id = $bookId") ;
$book = mysqli_fetch_assoc($query) ;

if($book) {
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = [];
    }
    
    // Cart key = bookId_format (jaise: 5_hardcopy)
    $cartKey = $bookId . '_' . $format;
    
    if(isset($_SESSION["cart"][$cartKey])){
        // Already hai to quantity barha do
        $_SESSION["cart"][$cartKey]['quantity']++;
    } else {
        // Naya item add karo
        $_SESSION["cart"][$cartKey] = [
            'id' => $book['book_id'],
            'title' => $book['book_title'],
            'author' => $book['book_author'],
            'image' => $book['book_cover'],
            'format' => $format,
            'price' => $price,
            'quantity' => 1
        ];
    }
    
    echo "success";
}
?>
