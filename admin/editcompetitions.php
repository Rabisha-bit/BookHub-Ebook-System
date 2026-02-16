<?php
include "includes/header.php";

$idtobeupdated = $_GET['id'];



// --- Fetch existing data ---
$query = mysqli_query($conn, "SELECT * FROM competitions WHERE comp_id='$idtobeupdated'");
$data = mysqli_fetch_assoc($query);


// --- Update form submit ---
if (isset($_POST["updatecompbtn"])) {

    $comp_title = $_POST['comp_title'];
    $comp_description = $_POST['comp_description'];
    $comp_type = $_POST['comp_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $prize_details = $_POST['prize_details'];
    $status = $_POST['status'];

    $updatequery = "
        UPDATE competitions 
        SET 
            comp_title='$comp_title',
            comp_description='$comp_description',
            comp_type='$comp_type',
            start_date='$start_date',
            end_date='$end_date',
            prize_details='$prize_details',
            status='$status'
        WHERE comp_id='$idtobeupdated'
    ";

    $result = mysqli_query($conn, $updatequery);

    if ($result) {
        echo "<script>alert('Competition updated successfully');
        window.location.href='managecompetitions.php';
        </script>";
    } else {
        echo "<script>alert('Failed to update competition');</script>";
    }
}

?>
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="fw-bold mb-4">Update Competition</h2>

        <form method="POST">

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Competition Title</label>
                <input type="text" name="comp_title" value="<?php echo $data['comp_title']; ?>" class="form-control"
                    required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="comp_description" class="form-control" rows="4"
                    required><?php echo $data['comp_description']; ?></textarea>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label class="form-label">Competition Type</label>
                <select name="comp_type" class="form-select" required>
                    <option value="">Select Type</option>
                    <option value="essay" <?php echo ($data['comp_type'] == 'essay') ? 'selected' : ''; ?>>Essay</option>
                    <option value="story" <?php echo ($data['comp_type'] == 'story') ? 'selected' : ''; ?>>Story</option>
                </select>
            </div>

            <!-- Dates -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date"
                        value="<?php echo date('Y-m-d', strtotime($data['start_date'])); ?>" class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date"
                        value="<?php echo date('Y-m-d', strtotime($data['end_date'])); ?>" class="form-control"
                        required>
                </div>
            </div>

            <!-- Prize Details -->
            <div class="mb-3">
                <label class="form-label">Prize Details</label>
                <input type="text" name="prize_details" value="<?php echo $data['prize_details']; ?>"
                    class="form-control" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="upcoming" <?php echo ($data['status'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming
                    </option>
                    <option value="active" <?php echo ($data['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="completed" <?php echo ($data['status'] == 'completed') ? 'selected' : ''; ?>>Completed
                    </option>
                </select>
            </div>

            <!-- Button -->
            <input name="updatecompbtn" type="submit" value="Update Competition" class="btn btn-primary" />

        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>