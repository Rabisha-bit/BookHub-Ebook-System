<?php

include("includes/header.php");

$categoryListQuery = "select * from bookcategory";
$data = mysqli_query($conn, $categoryListQuery);

if (isset($_POST['addbookbtn'])) {

    $title = $_POST['title'];
    $author = $_POST['author'];
    $shortDescription = $_POST['shortDescription'];
    $fullDescription = $_POST['fullDescription'];
    $category = $_POST['category'];



    $pdfType = $_POST['pdfType'];   // free or paid
    $pdfPrice = $_POST['pdfPrice'];

    $hardcopyPrice = $_POST['hardcopyPrice'];
    $cdPrice = $_POST['cdPrice'];


    if ($pdfType == "free") {
        $pdfPrice = 0;
    }


    $formatPDF = isset($_POST['formatPDF']) ? 1 : 0;
    $formatHardCopy = isset($_POST['formatHardCopy']) ? 1 : 0;
    $formatCD = isset($_POST['formatCD']) ? 1 : 0;

    // Book cover upload
    $bookCovername = $_FILES['bookCover']['name'];
    $bookCoverTmpName = $_FILES['bookCover']['tmp_name'];
    move_uploaded_file($bookCoverTmpName, "bookimages/" . $bookCovername);

// PDF upload
    $pdfFilename = $_FILES['pdfFile']['name'];
    $pdfFileTmpName = $_FILES['pdfFile']['tmp_name'];
    move_uploaded_file($pdfFileTmpName, "pdf/" . $pdfFilename);

    // INSERT QUERY UPDATED
    $query = "INSERT INTO `book` (
        book_title, 
        book_author, 
        short_description, 
        full_description, 
        book_cover,  
        category_id, 
        pdf_type,
        pdf_file,
        pdf_price, 
        hardcopy_price, 
        cd_price,
        format_pdf, 
        format_hardcopy, 
        format_cd
    ) VALUES (
        '$title',
        '$author',
        '$shortDescription',
        '$fullDescription',
        '$bookCovername',
        '$category',
        '$pdfType',
        '$pdfFilename',
        '$pdfPrice',
        '$hardcopyPrice',
        '$cdPrice',
        '$formatPDF',
        '$formatHardCopy',
        '$formatCD'
    )";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Book added successfully');
        window.location.href='allbooks.php';
        </script>";
    } else {
        echo "<script>alert('Failed to add book');</script>";
    }
}

?>



<div class="container my-5">
    
    <form class="row g-4 needs-validation" novalidate action="" method="post" enctype="multipart/form-data">

        <!-- Add New Book Header -->
        <div class="col-12">
            <h1 class="text-center font-weight-bold">Add New Book</h1>
            <hr>
        </div>

        <!-- Title & Author -->
        <div class="col-md-6">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
            <div class="invalid-feedback">Please provide a title.</div>
        </div>

        <div class="col-md-6">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
            <div class="invalid-feedback">Please provide the author's name.</div>
        </div>

        <!-- Short & Full Description -->
        <div class="col-md-6">
            <label for="shortDescription" class="form-label">Short Description</label>
            <textarea class="form-control" id="shortDescription" name="shortDescription" rows="3" required></textarea>
            <div class="invalid-feedback">Please provide a short description.</div>
        </div>

        <div class="col-md-6">
            <label for="fullDescription" class="form-label">Full Description</label>
            <textarea class="form-control" id="fullDescription" name="fullDescription" rows="3" required></textarea>
            <div class="invalid-feedback">Please provide a full description.</div>
        </div>

        <!-- Book Cover & PDF Upload -->
        <div class="col-md-6">
            <label class="form-label">Book Cover Image</label>
            <div class="upload-box mb-2" onclick="document.getElementById('bookCoverInput').click()">
                <i class="bi bi-image"></i><br>
                Click to upload book cover
            </div>
            <input type="file" class="form-control d-none" id="bookCoverInput" name="bookCover" accept="image/*"
                required>
            <img id="bookCoverPreview" class="img-fluid mt-2 rounded" style="max-height:180px; display:none;">
            <div class="invalid-feedback">Please upload a book cover image.</div>
        </div>

  <div class="col-md-6">
            <label class="form-label">PDF Upload</label>
            <div class="upload-box mb-2" onclick="document.getElementById('pdfInput').click()">
                <i class="bi bi-file-earmark-pdf"></i><br>
                Click to upload PDF
            </div>
            <input type="file" class="form-control d-none" id="pdfInput" name="pdfFile" accept="application/pdf"
                required>

            <!-- PDF thumbnail box -->
            <div id="pdfPreview" class="border rounded mt-2 p-3 text-center" style="display:none; max-height:200px;">
                <i class="bi bi-file-earmark-pdf" style="font-size:5rem; color:red;"></i>
                <div id="pdfFilename" class="mt-2 text-truncate"></div>
            </div>

            <div class="invalid-feedback">Please upload the PDF file.</div>
        </div>


        <!-- Category  -->
        <div class="col-md-6">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="" selected disabled>-- Select Category --</option>
                <?php foreach ($data as $category): ?>
                    <option value=<?php echo $category["category_id"] ?>><?php echo $category["category_name"] ?>
                    </option>
                <?php endforeach ?>
               
            </select>
            <div class="invalid-feedback">Please provide a category.</div>
        </div>
     
        <div class="col-md-6">
            <label class="form-label">PDF Version</label>
            <select class="form-select" id="pdfType" name="pdfType" required>
                <option value="free">Free</option>
                <option value="paid">Paid</option>
            </select>
        </div>


        <!-- Pricing -->
        <!-- Pricing Information -->
        <div class="col-12 mt-3">
            <h6>Pricing Information</h6>
            <hr>
        </div>


        <div class="col-md-4">
            <label for="pdfPrice" class="form-label">PDF Price (if Paid)</label>
            <input type="number" class="form-control" id="pdfPrice" name="pdfPrice" min="0" step="any">
            <div class="form-text">Enter price only if PDF is paid.</div>
        </div>



        <!-- Hardcopy Price -->
        <div class="col-md-4">
            <label for="hardcopyPrice" class="form-label">Hardcopy Price</label>
            <input type="number" class="form-control" id="hardcopyPrice" name="hardcopyPrice" min="0" step="any">
        </div>

        <!-- CD Price -->
        <div class="col-md-4">
            <label for="cdPrice" class="form-label">CD Price</label>
            <input type="number" class="form-control" id="cdPrice" name="cdPrice" min="0" step="any">
        </div>



        <div class="col-md-6">
            <h6>Format Availability</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="formatPDF" name="formatPDF" checked>
                <label class="form-check-label" for="formatPDF">PDF</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="formatHardCopy" name="formatHardCopy">
                <label class="form-check-label" for="formatHardCopy">Hard Copy</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="formatCD" name="formatCD">
                <label class="form-check-label" for="formatCD">CD</label>
            </div>
        </div>

        <!-- Submit -->
        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
            <button type="submit" class="btn btn-secondary btn-block p-3" name="addbookbtn">Add Book</button>
        </div>

    </form>
</div>




<?php include("includes/footer.php"); ?>