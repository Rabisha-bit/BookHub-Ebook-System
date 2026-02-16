<?php
include("includes/header.php");

$query = "SELECT * FROM bestselling_books";
$bestselling = mysqli_query($conn, $query);


?>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class=" d-flex flex-row
     justify-content-between align-items-center">
        <h1 class="h1 fw-bold mb-2 text-gray-800">All Best Selling Books</h1>
        <a href="addbestsellingbook.php" class="btn btn-secondary p-2 my-2">Add Book</a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book ID</th>
                            <th>Ranking</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bestselling as $book) { ?>
                            <tr>
                                <td><?php echo $book["id"] ?></td>
                                <td><?php echo $book["book_id"] ?></td>
                                <td><?php echo $book["ranking"] ?></td>
                                <td>
                                    <a href="updatebestsellingbook.php?id=<?php echo $book["id"] ?>"
                                        class="btn btn-warning btn-block"><i class="fa fa-pen-to-square"></i></a>

                                    <a href="deletebestsellingbook.php?id=<?php echo $book["id"] ?>"
                                        class="btn btn-danger btn-block"><i class="fa-regular fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<?php include("includes/footer.php"); ?>