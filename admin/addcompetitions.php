<?php 



include "includes/header.php";
if (isset($_POST["addcompbtn"])) {

$comp_title=$_POST['comp_title'];
$comp_description=$_POST['comp_description'];
$comp_type=$_POST['comp_type'];
$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];
$prize_details=$_POST['prize_details'];
$status=$_POST['status'];

$insertquery = "INSERT INTO `competitions` ( `comp_title`, `comp_description`, `comp_type`, `start_date`, `end_date`, `prize_details`, `status`) VALUES ('$comp_title', '$comp_description', '$comp_type', '$start_date', '$end_date', '$prize_details', '$status')";
$result = mysqli_query($conn, $insertquery);
if ($result) {
        echo "<script>alert('Competition added successfully');
        window.location.href='managecompetitions.php';
        </script>";
    } else {
        echo "<script>alert('Failed to add Competition');</script>";
    }

}



?>
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="fw-bold mb-4">Add New Competition</h2>

        <form  method="POST">
            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Competition Title</label>
                <input type="text" name="comp_title" class="form-control" required>
            </div>
            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="comp_description" class="form-control" rows="4" required></textarea>
            </div>
            <!-- Type -->
            <div class="mb-3">
                <label class="form-label">Competition Type</label>
                <select name="comp_type" class="form-select" required>
                    <option value="">Select Type</option>
                    <option value="essay">Essay</option>
                    <option value="story">Story</option>
                </select>
            </div>
            <!-- Dates -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>
            <!-- Prize Details -->
            <div class="mb-3">
                <label class="form-label">Prize Details</label>
                <input type="text" name="prize_details" class="form-control" placeholder="e.g., Rs 10,000 + Certificate" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="upcoming">Upcoming</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

           

            <!-- Button -->
            <input name="addcompbtn" type="submit" value="Add Competition" class="btn btn-primary"/>
                
           

        </form>
    </div>
</div>
<?php include "includes/footer.php";?>