<?php
include("includes/header.php");

// Handle Declare Winner form submission
if (isset($_POST['declare_winner'], $_POST['submission_id'], $_POST['competition_id'], $_POST['position'])) {
    $submission_id = $_POST['submission_id'];
    $competition_id = $_POST['competition_id'];
    $position = $_POST['position'];

    // Check if this position is already taken for this competition
    $checkPosition = mysqli_query($conn, "SELECT * FROM competition_winners WHERE competition_id='$competition_id' AND position='$position'");
    if (mysqli_num_rows($checkPosition) > 0) {
        echo "<div class='alert alert-warning'>This position is already assigned for this competition.</div>";
    } else {
        // Insert winner
        $insertWinner = "INSERT INTO competition_winners (competition_id, submission_id, position) 
                         VALUES ('$competition_id', '$submission_id', '$position')";
        if (mysqli_query($conn, $insertWinner)) {
            echo "<div class='alert alert-success'>Winner declared successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: Could not declare winner.</div>";
        }
    }
}

// Fetch approved submissions
$approvedSubmissions = mysqli_query($conn, "
    SELECT cs.submission_id, cs.comp_id, cs.submission_type, c.comp_title, u.user_name
    FROM competition_submissions cs
    INNER JOIN competitions c ON cs.comp_id = c.comp_id
    INNER JOIN users u ON cs.user_id = u.user_id
    LEFT JOIN competition_winners cw ON cs.submission_id = cw.submission_id
    WHERE cs.status='approved' AND cw.submission_id IS NULL
");
?>



<div class="container-fluid">
    <div class="py-3 d-flex justify-content-between align-items-center">
        <h1 class="m-0 font-weight-bold text-gray">Competition Winners</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Competition</th>
                            <th>User</th>
                            <th>Submission Type</th>
                            <th>Declare Winner</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($approvedSubmissions) > 0) {
                            while ($submission = mysqli_fetch_assoc($approvedSubmissions)) { ?>
                                <tr>
                                    <td><?php echo $submission['comp_title']; ?></td>
                                    <td><?php echo $submission['user_name']; ?></td>
                                    <td><?php echo $submission['submission_type']; ?></td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="submission_id"
                                                value="<?php echo $submission['submission_id']; ?>">
                                            <input type="hidden" name="competition_id"
                                                value="<?php echo $submission['comp_id']; ?>">
                                            <select name="position" class="form-control form-control-sm" required>
                                                <option value="">Select Position</option>
                                                <option value="first">First</option>
                                                <option value="second">Second</option>
                                                <option value="third">Third</option>
                                            </select>
                                            <button type="submit" name="declare_winner"
                                                class="btn btn-success btn-sm mt-1">Declare Winner</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">No approved submissions available for winners.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>