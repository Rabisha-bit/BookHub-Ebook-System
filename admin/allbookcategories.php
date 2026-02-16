<?php 
include("includes/header.php");

$query = "SELECT * FROM bookcategory";
$cateData = mysqli_query($conn, $query);


?>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class=" d-flex flex-row
     justify-content-between align-items-center">
    <h1 class="h1 fw-bold mb-2 text-gray-800">All Categories</h1>
    <a href="addbookcategories.php" class="btn btn-secondary p-2 my-2">Add Category</a>
    </div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
   
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Category Id</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cateData as $category) { ?>
                        <tr>
                            <td><?php echo $category["category_id"] ?></td>
                            <td><?php echo $category["category_name"] ?></td>
                            <td>
                                <a href="updatebookcategories.php?id=<?php echo $category["category_id"] ?>"
                                    class="btn btn-warning btn-block"><i class="fa fa-pen-to-square"></i></a>

                                <a href="deletebookcategories.php?id=<?php echo $category["category_id"] ?>"
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