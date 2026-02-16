<?php
$title = "Competitions | BOOKHUB";

include("header.php");

// Filter logic
$filter = $_GET['filter'] ?? 'all';

if ($filter == 'active') {
    $where = "WHERE status = 'active'";
} elseif ($filter == 'upcoming') {
    $where = "WHERE status = 'upcoming'";
} elseif ($filter == 'completed') {
    $where = "WHERE status = 'completed'";
} else {
    $where = ""; // all
}
// Fetch all competitions
$compDataQuery = mysqli_query($conn, "SELECT * FROM `competitions` $where ");
?>

<div class="container-fluid my-4">
    <div class="comp-banner text-center">
        <h1>Welcome to Literary Competition Portal</h1>
    </div>
    <!-- Filter Buttons -->
    <div class="mb-4 text-center filter">
        <a href="?filter=all" class="filterbtn <?php if ($filter == 'all')
            echo 'active'; ?>">All</a>
        <a href="?filter=active" class="filterbtn <?php if ($filter == 'active')
            echo 'active'; ?>">Active</a>
        <a href="?filter=upcoming" class="filterbtn<?php if ($filter == 'upcoming')
            echo 'active'; ?>">Upcoming</a>
        <a href="?filter=completed" class="filterbtn<?php if ($filter == 'completed')
            echo 'active'; ?>">Completed</a>
    </div>
  
  <!-- FLOATING CONTACT ICON -->
<a href="index.php" class="floating-contact">
  <i class="fa-solid fa-home"></i>
</a>
    <div class="row">

        <?php if (mysqli_num_rows($compDataQuery) > 0): ?>
            <?php foreach ($compDataQuery as $comp): ?>

                <div class="col-md-4 mb-4">
                    <div class="card comp-card h-100">

                        <div class="card-body d-flex flex-column">

                            <!-- Status Badge -->
                            <div class="mb-2">
                                <?php
                                $statusClass = strtolower($comp['status']);
                                echo "<span class='status-badge status-$statusClass'>" .
                                    ucfirst($comp['status'])
                                    . "</span>";
                                ?>
                            </div>

                            <h5 class="comp-title mb-2">
                                <?php echo htmlspecialchars($comp['comp_title']); ?>
                            </h5>

                            <p><span class="comp-label">Type:</span>
                                <span class="comp-value"><?php echo htmlspecialchars($comp['comp_type']); ?></span>
                            </p>

                            <p><span class="comp-label">Start:</span>
                                <span class="comp-value"><?php echo date('M d, Y', strtotime($comp['start_date'])); ?></span>
                            </p>

                            <p><span class="comp-label">End:</span>
                                <span class="comp-value"><?php echo date('M d, Y', strtotime($comp['end_date'])); ?></span>
                            </p>

                            <p><span class="comp-label">Prize:</span>
                                <span class="comp-value"><?php echo htmlspecialchars($comp['prize_details']); ?></span>
                            </p>

                            <?php if ($comp['status'] == 'active'): ?>
                                <a href="index.php #live-comp"
                                    class="explorebtn mt-auto text-center" style="border-radius: 10px; font-weight:600;">
                                    Submit Your Entry
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>

            <div class="col-12">
                <div class="alert alert-info text-center p-4" style="border-radius:12px; font-size:1.1rem;">
                    No competitions available at the moment.
                </div>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php include("footer.php"); ?>