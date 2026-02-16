<?php

include("includes/header.php");

$allcalendar = "SELECT * FROM `kids_books_calendar`";
$allcalendardata = mysqli_query($conn, $allcalendar);

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="py-3 d-flex justify-content-between align-items-center">
            <h1 class="m-0 font-weight-bold text-gray">All Calendar</h1>
            <a href="calendar_add.php" Class="btn btn-secondary">Add Calendar</a>
        </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                         <tr>
                            <?php foreach ($allcalendardata as $calendar): ?>
                                <td><?php echo $calendar['id']; ?></td>
                                <td>
                                    <img width="80px" src="calendaricons/<?php echo $calendar['book_icon'] ?>" alt="">
                                </td>
                                <td><?php echo $calendar['title']; ?></td>
                                <td><?php echo $calendar['description']; ?></td>
                                <td><?php echo $calendar['release_date']; ?></td>
                                
                                <td>
                                    <a href="updatecalendar.php?id=<?php echo $calendar['id']; ?>"
                                        class="btn btn-primary btn-sm btn-block"><i class="fa fa-pen-to-square"></i></a>
                                    <a href="deletecalendar.php?id=<?php echo $calendar['id']; ?>"
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