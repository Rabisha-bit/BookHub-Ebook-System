<?php
$title = "Books Detail | BOOKHUB";

include("header.php");

$bookId = $_GET['id'];

$bookQuery = "SELECT * FROM book 
              INNER JOIN bookcategory ON book.category_id = bookcategory.category_id
              WHERE book_id = $bookId";
$bookData = mysqli_query($conn, $bookQuery);
$book = mysqli_fetch_assoc($bookData);
?>

<!-- FLOATING CONTACT ICON -->
<a href="index.php" class="floating-contact">
    <i class="fa-solid fa-home"></i>
</a>

<div class="container book-detail-container my-5">

    <div class="row g-4">

        <!-- LEFT: Book Cover -->
        <div class="col-md-4 col-12 text-center">
            <div class="detail-image-box">
                <img src="./admin/bookimages/<?php echo $book['book_cover']; ?>" class="book-detail-img" alt="">
            </div>
        </div>

        <!-- RIGHT: Book Info -->
        <div class="col-md-8 col-12">

            <div class="detail-box">

                <h1 class="detail-title"><?php echo $book['book_title']; ?></h1>

                <p class="detail-author">
                    <i class="fa-solid fa-user-pen"></i>
                    <span><?php echo $book['book_author']; ?></span>
                </p>

                <p class="detail-category">
                    <i class="fa-solid fa-layer-group"></i>
                    Category:
                    <span><?php echo $book['category_name']; ?></span>
                </p>

                <hr>

                <!-- FULL DESCRIPTION -->
                <h4 class="section-title">About This Book</h4>
                <p class="detail-full">
                    <?php echo nl2br($book['full_description']); ?>
                </p>

                <hr>

                <!-- PRICES -->
                <h4 class="section-title mt-3">Available Formats</h4>
                <div class="detail-prices">

                    <div class="price-tag" data-format="pdf" data-available="1"
                        data-type="<?php echo $book['pdf_type']; ?>" data-price="<?php echo $book['pdf_price']; ?>">
                        <i class="fa-regular fa-file-pdf"></i>
                        <span class="tick" style="display:none; color:green;"><i
                                class="fa-regular fa-circle-check"></i></span>
                        <span>
                            <?php echo ($book['pdf_type'] == "free") ? "Free PDF" : "PDF: Rs." . $book['pdf_price']; ?>
                        </span>
                    </div>

                    <?php if ($book['format_hardcopy'] == 1): ?>
                        <div class="price-tag available" data-available="1" data-format="hardcopy" data-type="paid"
                            data-price="<?php echo $book['hardcopy_price']; ?>">
                            <i class="fa-solid fa-book"></i>
                            <span class="tick" style="display:none; color:green;"><i
                                    class="fa-regular fa-circle-check"></i></span>
                            <span>Hardcopy: Rs.<?php echo $book['hardcopy_price']; ?></span>
                        </div>
                    <?php else: ?>
                        <div class="price-tag unavailable" data-available="0" data-format="hardcopy" data-type="paid"
                            data-price="<?php echo $book['hardcopy_price']; ?>">
                            <i class="fa-solid fa-book"></i>
                            <span class="tick" style="display:none; color:green;"><i
                                    class="fa-regular fa-circle-check"></i></span>
                            <span>Hardcopy: Rs.<?php echo $book['hardcopy_price']; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($book['format_cd'] == 1): ?>
                        <div class="price-tag available" data-available="1" data-format="cd" data-type="paid"
                            data-price="<?php echo $book['cd_price']; ?>">
                            <i class="fa-solid fa-compact-disc"></i>
                            <span class="tick" style="display:none; color:green;"><i
                                    class="fa-regular fa-circle-check"></i></span>
                            <span>CD: Rs.<?php echo $book['cd_price']; ?></span>
                        </div>
                    <?php else: ?>
                        <div class="price-tag unavailable" data-available="0" data-format="cd" data-type="paid"
                            data-price="<?php echo $book['cd_price']; ?>">
                            <i class="fa-solid fa-compact-disc"></i>
                            <span class="tick" style="display:none; color:green;"><i
                                    class="fa-regular fa-circle-check"></i></span>
                            <span>CD: Rs.<?php echo $book['cd_price']; ?></span>
                        </div>
                    <?php endif; ?>

                </div>


                <div id="toast" class="custom-toast"></div>



                <!-- BUTTONS -->
                <div class="detail-buttons mt-4">
                    <button class="add-to-cart" id="btnAction" data-book-id="<?php echo $book['book_id']; ?>">
                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<!-- jquery cdn -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- ajax for add to cart -->

<script>
$(document).ready(function() {
    let selectedFormat = null;
    let selectedPrice = 0;
    let selectedType = '';

    // Toast function
    function showToast(message, type = 'success') {
        const toast = $('#toast');
        toast.text(message);
        toast.removeClass('success error');
        toast.addClass(type);
        toast.addClass('show');
        
        setTimeout(function() {
            toast.removeClass('show');
        }, 3000);
    }

    // Jab koi format click ho
    $('.price-tag.available').click(function() {
        // Pehle sab se selection hata do
        $('.price-tag').removeClass('selected');
        $('.tick').hide();
        
        // Ab is format ko select karo
        $(this).addClass('selected');
        $(this).find('.tick').show();
        
        // Selected format ki details save karo
        selectedFormat = $(this).data('format');
        selectedPrice = $(this).data('price');
        selectedType = $(this).data('type');
        
        // Format name
        let formatName = selectedFormat === 'pdf' ? 'PDF' : 
                        selectedFormat === 'hardcopy' ? 'Hardcopy' : 'CD';
        
        showToast(formatName + ' selected!', 'success');
    });

    // Add to Cart button par click
    $('#btnAction').click(function() {
        let bookId = $(this).data('book-id');
        
        // Check: koi format select hai ya nahi?
        if(!selectedFormat) {
            showToast('Please select a format first!', 'error');
            return;
        }
        
        // Ajax call
        $.ajax({
            url: 'add-to-cart.php',
            type: 'POST',
            data: {
                book_id: bookId,
                format: selectedFormat,
                price: selectedPrice,
                type: selectedType
            },
            success: function(response) {
                showToast('Book added to cart successfully!', 'success');
                setTimeout(function() {
                    window.location.href = 'cart.php';
                }, 1500);
            },
            error: function() {
                showToast('Something went wrong!', 'error');
            }
        });
    });
});
</script>