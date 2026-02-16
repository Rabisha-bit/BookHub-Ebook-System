<?php

include("includes/header.php");

$compDataQuery = mysqli_query($conn, "SELECT * FROM `competitions`");

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="py-3 d-flex justify-content-between align-items-center">
        <h1 class="m-0 font-weight-bold text-gray">All Books</h1>
        <a href="addcompetitions.php" class="btn btn-secondary mb-3">
            <i class="fas fa-plus"></i> Create New Competition
        </a>
    </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Prize</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                        <?php foreach ($compDataQuery as $comp) { ?>
                    <tr>
                            <td><?php echo $comp['comp_id'] ?></td>
                            <td><?php echo $comp['comp_title'] ?></td>
                            <td><?php echo $comp['comp_type'] ?></td>
                            <td><?php echo $comp['start_date'] ?></td>
                            <td><?php echo $comp['end_date'] ?></td>
                            <td><?php echo $comp['prize_details'] ?></td>
                            <td><?php echo $comp['status'] ?></td>

                            <td>
                                <a href="editcompetitions.php?id=<?php echo $comp['comp_id'] ?>"
                                    class="btn btn-sm btn-warning mb-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletecompetitions.php?id=<?php echo $comp['comp_id'] ?>"
                                    class="btn btn-sm btn-danger mb-1"
                                    onclick="return confirm('Are you sure you want to delete this competition?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    <tbody>



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