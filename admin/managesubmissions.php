<?php
include("includes/header.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submission_id'], $_POST['status'])) {
    $submission_id = $_POST['submission_id'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE competition_submissions SET status='$status' WHERE submission_id='$submission_id'";
    mysqli_query($conn, $updateQuery);
    echo "<div class='alert alert-success'>Submission status updated successfully.</div>";
}


$allsubmissionsData = mysqli_query($conn, "
    SELECT cs.*, c.comp_title, u.user_name 
    FROM `competition_submissions` cs
    INNER JOIN competitions c ON cs.comp_id = c.comp_id
    INNER JOIN users u ON cs.user_id = u.user_id
");
?>

<div class="container-fluid">
    <div class="py-3 d-flex justify-content-between align-items-center">
        <h1 class="m-0 font-weight-bold text-gray">All Submissions</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Competition</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Submitted at</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (mysqli_num_rows($allsubmissionsData) > 0) { 
                        while($submission = mysqli_fetch_assoc($allsubmissionsData)) { ?>
                            <tr>
                                <td><?php echo $submission['submission_id']; ?></td>
                                <td><?php echo $submission['comp_title']; ?></td>
                                <td><?php echo $submission['user_name']; ?></td>
                                <td><?php echo $submission['submission_type']; ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($submission['submitted_at'])); ?></td>
                                <td><form method="post" >
                                        <input type="hidden" name="submission_id" value="<?php echo $submission['submission_id']; ?>">
                                        <select name="status">
                                            <option value="submitted" <?php if ($submission['status'] == 'submitted') echo ' selected'; ?>>Submitted</option>
                                            <option value="under_review" <?php if ($submission['status'] == 'under_review') echo ' selected'; ?>>Under Review</option>
                                            <option value="approved" <?php if ($submission['status'] == 'approved') echo ' selected'; ?>>Approved</option>
                                            <option value="rejected" <?php if ($submission['status'] == 'rejected') echo ' selected'; ?>>Rejected</option>
                                        </select></td>
                                <td >
                                    
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7">No submissions found.</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
