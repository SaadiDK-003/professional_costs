<?php
require_once '../core/database.php';
$pageTitle = 'View Profile';
if (!is_loggedin()) {
?><script>
        window.location.href = "../login.php";
    </script><?php
            }
                ?>
<?php
include_once '../includes/header.php';
include_once '../includes/aside.php';

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $pageTitle ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $pageTitle ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= $pageTitle ?></h3>
                            <h3 class="card-title position-absolute text-success h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body view-profile">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="content">
                                        <span>Name</span>
                                        <h5><?= $username ?></h5>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="content">
                                        <span>Email</span>
                                        <h5><?= $email ?></h5>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="content">
                                        <span>Mobile Number</span>
                                        <h5><?= $contact ?></h5>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="content">
                                        <span>Job Position</span>
                                        <h5><?= $role ?></h5>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="content">
                                        <span>Number of Points</span>
                                        <h5>
                                            <?php
                                            $getTotalP = $db->query("CALL `get_total_emp_points`($id)");
                                            $total_points = mysqli_fetch_object($getTotalP);
                                                echo $total_points->total_points ?? 0;
                                            $getTotalP->close();
                                            $db->next_result();
                                            ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include_once '../includes/footer.php'; ?>
<script>
    $(document).ready(function() {});
</script>