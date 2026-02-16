<?php
session_start();
include "database/config.php"; // your database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // adjust path if needed

$user_id = $_SESSION["user_id"];

// Get form data
$first_name  = $_POST['c_fname'];
$last_name   = $_POST['c_lname'];
$email       = $_POST['c_email'];
$phone       = $_POST['c_phone'];
$address     = $_POST['c_address'];
$city        = $_POST['c_city'];
$zip         = $_POST['c_zip'];
$country     = $_POST['c_country'];
$order_notes = $_POST['c_notes'];

// Get cart items
$cartItems = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
$subtotal  = 0;
$cartData  = [];
while ($item = mysqli_fetch_assoc($cartItems)) {
    $subtotal += $item['price'] * $item['quantity'];
    $cartData[] = $item;
}

// Insert order
$sql = "INSERT INTO orders (user_id, first_name, last_name, email, phone, address, city, zip_code, country, order_notes, total_amount, status)
        VALUES ('$user_id', '$first_name', '$last_name', '$email', '$phone', '$address', '$city', '$zip', '$country', '$order_notes', '$subtotal', 'pending')";

if (mysqli_query($conn, $sql)) {
    $order_id = mysqli_insert_id($conn);

    // Insert order items
    foreach ($cartData as $item) {
        $book_id  = $item['book_id'];
        $quantity = $item['quantity'];
        $price    = $item['price'];
        mysqli_query($conn, "INSERT INTO order_items (order_id, book_id, quantity, price) VALUES ('$order_id', '$book_id', '$quantity', '$price')");
    }

    // Clear cart
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

    // Build order items table for email
    $orderItemsTable = '<table style="width:100%; border-collapse:collapse;">';
    $orderItemsTable .= '<tr style="background:#222; color:#fff;">
        <th style="padding:8px;text-align:left;">Book</th>
        <th style="padding:8px;text-align:center;">Qty</th>
        <th style="padding:8px;text-align:right;">Price</th>
    </tr>';

    foreach ($cartData as $item) {
        $book_id = $item['book_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total = $quantity * $price;

        $bookQuery = mysqli_query($conn, "SELECT book_title, book_cover, pdf_file, pdf_type, pdf_price FROM book WHERE book_id='$book_id'");
        $book = mysqli_fetch_assoc($bookQuery);

        $book_title = $book['book_title'];
        $book_cover = $book['book_cover']; // image path

        $orderItemsTable .= '<tr style="border-bottom:1px solid #ddd;">
            <td style="padding:8px; display:flex; align-items:center;">
                <img src="./admin/bookimages/'.$book_cover.'" alt="'.$book_title.'" style="width:50px; height:70px; object-fit:cover; margin-right:10px;">
                '.$book_title.'
            </td>
            <td style="padding:8px;text-align:center;">'.$quantity.'</td>
            <td style="padding:8px;text-align:right;">PKR '.$total.'</td>
        </tr>';
    }

    $orderItemsTable .= '<tr style="font-weight:bold;">
        <td colspan="2" style="padding:8px;text-align:right;">Total:</td>
        <td style="padding:8px;text-align:right;">PKR '.$subtotal.'</td>
    </tr>';
    $orderItemsTable .= '</table>';

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rabisha2698@gmail.com'; 
        $mail->Password   = 'yoov gjcz uglc noxb'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('rabisha2698@gmail.com', 'BookHub');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Order Has Been Placed - BookHub';

        $mail->Body = '<html><body style="font-family:Arial,sans-serif; background:#f4f4f4; padding:20px;">
        <div style="max-width:600px; margin:0 auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
            <div style="background:#222; padding:20px; text-align:center; color:#fff;">
                <h2 style="margin:0;">Order Confirmation</h2>
                <p style="margin:5px 0 0;">Thank you for shopping with BookHub</p>
            </div>

            <div style="padding:20px;">
                <p>Hello <strong>'.$first_name.' '.$last_name.'</strong>,</p>
                <p>Your order has been received and is currently <strong>pending approval</strong>. Here are your order details:</p>

                '.$orderItemsTable.'

                <p style="margin-top:20px;">Shipping Address:<br>
                '.$address.', '.$city.', '.$zip.', '.$country.'<br>
                Phone: '.$phone.'<br>
                Email: '.$email.'</p>

                <p>We will notify you once your order is approved. Thank you for choosing BookHub!</p>

                <p style="text-align:center; margin-top:20px;">
                    <a href="index.php" style="display:inline-block; padding:10px 20px; background:#2a5dff; color:#fff; text-decoration:none; border-radius:5px;">Continue Shopping</a>
                </p>

                <p>Warm regards,<br><strong>Team BookHub</strong></p>
            </div>

            <div style="background:#f0f0f0; padding:12px; text-align:center; font-size:12px; color:#555;">
                This is an automated message — please do not reply.
            </div>
        </div>
        </body></html>';

        $mail->AltBody = 'Your order has been placed successfully. Order ID: '.$order_id.' Total: '.$subtotal.' Continue shopping: https://yourdomain.com/index.php';

        // Attach PDFs for paid books
        foreach ($cartData as $item) {
            $book_id = $item['book_id'];
            $bookQuery = mysqli_query($conn, "SELECT book_title, pdf_file, pdf_type FROM book WHERE book_id='$book_id'");
            $book = mysqli_fetch_assoc($bookQuery);

            if ($book['pdf_type'] === 'paid' && !empty($book['pdf_file'])) {
                $pdfPath = __DIR__ . './admin/pdf/' . $book['pdf_file'];
                if (file_exists($pdfPath)) {
                    $mail->addAttachment($pdfPath, $book['book_title'] . '.pdf');
                }
            }
        }

        $mail->send();

    } catch (Exception $e) {
        // Optional: log $e->getMessage()
    }

    echo "<script>
            alert('Your order has been placed successfully and is pending admin approval!');
            window.location.href='index.php';
          </script>";

} else {
    echo "<script>
            alert('Something went wrong! Please try again.');
            window.history.back();
          </script>";
}
?>
