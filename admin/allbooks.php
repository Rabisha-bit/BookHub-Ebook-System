<?php

include("includes/header.php");

$allbooksquery = "SELECT * FROM `book` INNER JOIN `bookcategory` ON book.category_id = bookcategory.category_id";
$allbooksdata = mysqli_query($conn, $allbooksquery);

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="py-3 d-flex justify-content-between align-items-center">
            <h1 class="m-0 font-weight-bold text-gray">All Books</h1>
            <a href="addbooks.php" Class="btn btn-secondary">Add Books</a>
        </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>PDF Type</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                         <tr>
                            <?php foreach ($allbooksdata as $books): ?>
                                <td><?php echo $books['book_id']; ?></td>
                                <td>
                                    <img width="80px" src="bookimages/<?php echo $books['book_cover'] ?>" alt="">
                                </td>
                                <td><?php echo $books['book_title']; ?></td>
                                <td><?php echo $books['book_author']; ?></td>
                                <td><?php echo $books['category_name']; ?></td>
                                <td><?php echo $books['pdf_type']; ?></td>
                                <td>
                                    <?php if ($books['format_pdf']): ?>
                                        <span class="btn btn-sm btn-danger btn-block me-1">
                                           <span class="mx-2"><i class="fa-regular fa-file-pdf"></i></span> 
                                           Rs. <?php echo $books['pdf_price']; ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($books['format_hardcopy']): ?>
                                        <span class="btn btn-sm btn-primary btn-block me-1">
                                            <span class=" mx-2" ><i class="fa-solid fa-book"></i></span>
                                            Rs. <?php echo $books['hardcopy_price']; ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($books['format_cd']): ?>
                                        <span class="btn btn-sm btn-block btn-warning">
                                            <span class="mx-2"><i class="fa-solid fa-compact-disc"></i></span>
                                            Rs. <?php echo $books['cd_price']; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="editbooks.php?id=<?php echo $books['book_id']; ?>"
                                        class="btn btn-primary btn-sm btn-block"><i class="fa fa-pen-to-square"></i></a>
                                    <a href="deletebooks.php?id=<?php echo $books['book_id']; ?>"
                                        class="btn btn-danger btn-sm btn-block"
                                        onclick="return confirm('Are you sure you want to delete this book?');"><i
                                            class="fa-regular fa-trash-can"></i></a>
                                </td>

                            </tr>
                        <?php endforeach ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include("includes/footer.php"); ?>