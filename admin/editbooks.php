<?php
include("includes/header.php");

// Fetch categories
$categoryListQuery = "SELECT * FROM bookcategory";
$data = mysqli_query($conn, $categoryListQuery);

$bookId = $_GET['id'];

$bookQuery = "SELECT * FROM book WHERE book_id = $bookId";
$bookResult = mysqli_query($conn, $bookQuery);
$book = mysqli_fetch_assoc($bookResult);

if (!$book) {
    echo "<div class='alert alert-danger'>Book not found!</div>";
    exit;
}


if (isset($_POST['updatebookbtn'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $shortDescription = $_POST['shortDescription'];
    $fullDescription = $_POST['fullDescription'];
    $category = $_POST['category'];

    $pdftype = $_POST['pdfType'];
    $pdfPrice = $_POST['pdfPrice'];

    $hardcopyPrice = $_POST['hardcopyPrice'];
    $cdPrice = $_POST['cdPrice'];


    if ($pdftype == "free") {
        $pdfPrice = 0;
    }
    $formatPDF = isset($_POST['formatPDF']) ? 1 : 0;
    $formatHardCopy = isset($_POST['formatHardCopy']) ? 1 : 0;
    $formatCD = isset($_POST['formatCD']) ? 1 : 0;
    $bookCovername = $_FILES['bookCover']['name'];
    $bookCoverTmpName = $_FILES['bookCover']['tmp_name'];
    move_uploaded_file($bookCoverTmpName, "bookimages/" . $bookCovername);


    // Upload Book Cover if new one is provided
    if (!empty($_FILES['bookCover']['name'])) {
        $bookCovername = $_FILES['bookCover']['name'];
        $bookCoverTmpName = $_FILES['bookCover']['tmp_name'];
        move_uploaded_file($bookCoverTmpName, "bookimages/" . $bookCovername);
    } else {
        $bookCovername = $book['book_cover'];
    }
    if (!empty($_FILES['pdfFile']['name'])) {
        $pdfFilename = $_FILES['pdfFile']['name'];
        $pdfFileTmpName = $_FILES['pdfFile']['tmp_name'];
        move_uploaded_file($pdfFileTmpName, "pdf/" . $pdfFilename);
    } else {
        $pdfFilename = $book['pdf_file'];
    }


    $updateQuery = "UPDATE book SET
        book_title='$title',
        book_author='$author',
        short_description='$shortDescription',
        full_description='$fullDescription',
        book_cover='$bookCovername',
        pdf_file='$pdfFilename',
        pdf_type='$pdftype',
        category_id='$category',
        hardcopy_price='$hardcopyPrice',
        cd_price='$cdPrice',
        pdf_price='$pdfPrice',
        format_pdf='$formatPDF',
        format_hardcopy='$formatHardCopy',
        format_cd='$formatCD'
        WHERE book_id=$bookId";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Book updated successfully'); window.location.href='allbooks.php';</script>";
    } else {
        echo "<script>alert('Failed to update book');</script>";
    }
}
?>

<div class="container my-5">
    <h3 class="mb-4">Edit Book</h3>
    <form class="row g-4 needs-validation" novalidate action="" method="post" enctype="multipart/form-data">

        <!-- Book Header -->
        <div class="col-12">
            <h5>Edit Book Details</h5>
            <hr>
        </div>

        <!-- Title & Author -->
        <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $book['book_title']; ?>"
                required>
            <div class="invalid-feedback">Please provide a title.</div>
        </div>

        <div class="col-md-6">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author"
                value="<?php echo $book['book_author']; ?>" required>
            <div class="invalid-feedback">Please provide the author's name.</div>
        </div>

        <!-- Short & Full Description -->
        <div class="col-md-6">
            <label for="shortDescription" class="form-label">Short Description</label>
            <textarea class="form-control" id="shortDescription" name="shortDescription" rows="3"
                required><?php echo $book['short_description']; ?></textarea>
            <div class="invalid-feedback">Please provide a short description.</div>
        </div>

        <div class="col-md-6">
            <label for="fullDescription" class="form-label">Full Description</label>
            <textarea class="form-control" id="fullDescription" name="fullDescription" rows="3"
                required><?php echo $book['full_description']; ?></textarea>
            <div class="invalid-feedback">Please provide a full description.</div>
        </div>

        <!-- Book Cover & PDF Upload -->
        <div class="col-md-6">
            <label class="form-label">Book Cover Image</label>
            <div class="upload-box mb-2" onclick="document.getElementById('bookCoverInput').click()">
                <i class="bi bi-image"></i><br>
                Click to upload new cover
            </div>
            <input type="file" class="form-control d-none" id="bookCoverInput" name="bookCover" accept="image/*">
            <img src="bookimages/<?php echo $book['book_cover']; ?>" class="img-fluid mt-2 rounded"
                style="max-height:180px;">
        </div>

        <div class="col-md-6">
            <label class="form-label">PDF Upload</label>
            <div class="upload-box mb-2" onclick="document.getElementById('pdfInput').click()">
                <i class="bi bi-file-earmark-pdf"></i><br>
                Click to upload new PDF
            </div>
            <input type="file" class="form-control d-none" id="pdfInput" name="pdfFile" accept="application/pdf">
            <a href="pdf/<?php echo $book['pdf_file']; ?>" target="_blank">View current PDF</a>
        </div>

        <!-- Category & Language -->
        <div class="col-md-6">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="" disabled>-- Select Category --</option>
                <?php foreach ($data as $category): ?>
                    <option value="<?php echo $category["category_id"]; ?>" <?php if ($category["category_id"] == $book['category_id'])
                           echo "selected"; ?>>
                        <?php echo $category["category_name"]; ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">PDF Version</label>
            <select class="form-select" id="pdfType" name="pdfType" required>
                <option value="free" <?php if ($book['pdf_type'] == 'free')
                    echo 'selected'; ?>>Free</option>
                <option value="paid" <?php if ($book['pdf_type'] == 'paid')
                    echo 'selected'; ?>>Paid</option>

            </select>
        </div>



        <!-- Pricing -->
        <div class="col-md-4">
            <label for="pdfPrice" class="form-label">PDF Price (if Paid)</label>
            <input type="number" value="<?php echo $book['pdf_price']; ?>" class="form-control" id="pdfPrice"
                name="pdfPrice" min="0" step="any">
            <div class="form-text">Enter price only if PDF is paid.</div>
        </div>



        <!-- Hardcopy Price -->
        <div class="col-md-4">
            <label for="hardcopyPrice" class="form-label">Hardcopy Price</label>
            <input type="number" value="<?php echo $book['hardcopy_price']; ?>" class="form-control" id="hardcopyPrice"
                name="hardcopyPrice" min="0" step="any">
        </div>

        <!-- CD Price -->
        <div class="col-md-4">
            <label for="cdPrice" class="form-label">CD Price</label>
            <input type="number" value="<?php echo $book['cd_price']; ?>" class="form-control" id="cdPrice"
                name="cdPrice" min="0" step="any">
        </div>

        <!-- Formats -->
        <div class="col-md-6">
            <h6>Format Availability</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="formatPDF" name="formatPDF" <?php if ($book['format_pdf'])
                    echo "checked"; ?>>
                <label class="form-check-label" for="formatPDF">PDF</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="formatHardCopy" name="formatHardCopy" <?php if ($book['format_hardcopy'])
                    echo "checked"; ?>>
                <label class="form-check-label" for="formatHardCopy">Hard Copy</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="formatCD" name="formatCD" <?php if ($book['format_cd'])
                    echo "checked"; ?>>
                <label class="form-check-label" for="formatCD">CD</label>
            </div>
        </div>

        <!-- Submit -->
        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-block" name="updatebookbtn">Update Book</button>
        </div>

    </form>
</div>

<?php include("includes/footer.php"); ?>